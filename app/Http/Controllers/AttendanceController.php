<?php

namespace App\Http\Controllers;

use App\Models\Congress;
use App\Models\Engagement;
use App\Models\Kee;
use App\Models\Rank;
use Carbon\Carbon;
use Cassandra\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 *
 */
class AttendanceController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Inertia\Response
   */
  public function index(Request $request)
  {
    if (Auth::check()) {
      $search_term = htmlentities($request->term, ENT_QUOTES, 'UTF-8', false);
      $now =  Carbon::now();
      $kee_ids = Kee::all()->pluck('id')->toArray();

      // Query to get the planned / future engagement
      $kee_engagement_planned_current = Engagement::query()->rightJoin('kees', function ($join) use ($now) {
        $join->on(function ($on) use ($now) {
          $on->whereRaw("JSON_CONTAINS(
              engagements.kee_id,
              JSON_OBJECT(\"id\",CAST(kees.id AS CHAR(50)
              )))");
        });
      })->orderBy('engagements.id', 'DESC');

      $collection = $kee_engagement_planned_current->get();

      // Removed any record with an empty KEE id as a result of the join
      $collection->map(function ($item)  use ($collection) {
        if ($item->kee_id != null) {
          $item->kee_id = $item->id;
        }
      });

      // Get Kee based on attendance and associated engagements
      $kees = Engagement::query()->Join('kees', function ($join) use ($now) {
        $join->on(function ($on) use ($now) {
          $on->whereRaw("JSON_CONTAINS(
              engagements.kee_id,
              JSON_OBJECT(\"id\",CAST(kees.id AS CHAR(50)
              )))");
        });
      })->Join('ranks', function ($join) {
        $join->on('kees.id', '=', 'ranks.kee_id')
          ->on('ranks.id', '=', DB::raw("(SELECT MAX(id) FROM ranks WHERE ranks.kee_id = kees.id AND (ranks.engagement_id = engagements.id) )"));
      })->orderBy('ranks.id', 'DESC')->get();

      $congresses = Congress::query()->orderBy('name', 'ASC')->get()->pluck('name')->toArray();

      $merge = $kees->mergeRecursive($collection);
      $merged_kees = $merge->toArray();
      $kee_details = $this->getKeeEngagementRankDetails($merged_kees, $congresses, $kee_ids, $now);

      // Perform search based on KEE title, firstname and lastname and congress name
      if (!empty($search_term) && !empty($kee_details)) {
        $kee_d = [];
        foreach($kee_details as $value) {
          if (!empty($value)) {
            foreach ($value as $key => $details) {
                if ((!empty($key) && stristr($key, $search_term) !== false)) {
                  $kee_d['details'][$key] = $details;
                }
                elseif($details) {
                  foreach ($details as $details_key => $value) {
                    if((!empty($details_key) && stristr($details_key, $search_term) !== false)) {
                      $kee_d['details'][$key] = $details;
                    }
                  }
                }
              }
            }
          }
        $kee_details = $kee_d;
      }

      if (!empty($kee_details)) {
        $kee_details = $this->paginates($kee_details['details'])->appends($request->query());
      }
      return Inertia::render('LeicaComponent/Attendance',
        [
          'kees' => $kee_details,
          'congresses' => $congresses,
          'search_term' => $search_term,
          'attendance' => $this->getKeeAttendance($merged_kees, $congresses, $kee_ids)
        ]);
    }
  }

  /**
   * Create a bespoke pagination from array of records
   *
   * @param $details
   * @return LengthAwarePaginator
   */
  public function paginates($details): LengthAwarePaginator
  {

    // This basically gets the request's page variable or defaults to 1
    $page = Paginator::resolveCurrentPage('page') ?: 1;

    $perPage = 15;

    // Assume 15 items per page... so start index to slice our array
    $startIndex = ($page - 1) * $perPage;

    // Length aware paginator needs a total count of items to paginate properly
    $total = count($details);

    // Eliminate the non-relevant items
    $results = array_slice($details, $startIndex, $perPage);

    // Return the paginated record
    return new LengthAwarePaginator($results, $total, $perPage, $page, [
      'path' => Paginator::resolveCurrentPath(),
      'pageName' => 'page',
    ]);
  }

  /**
   * Logic to get the KEEs attendance
   *
   * @param $records
   * @param $congress_name
   * @param $kee_ids
   * @return array
   */
  public function getKeeAttendance($records, $congress_name, $kee_ids): array
  {
    $kee_attendance = [];
    if (!empty($records)) {
      foreach ($records as $value) {
        if (in_array($value['kee_id'], $kee_ids)) {
          if (in_array($value['congress'], $congress_name)) {
            if(!empty($value['attendance']) && $value['attendance'] == 'Yes') {
              $kee_attendance[$value['title'] . ' ' . $value['firstname'] . ' ' . $value['lastname']]['attendance'][] = 1;
            }
          }
        }
      }
      return $kee_attendance;
    }
  }

  /**
   * Implementation to formulate KEE details based on their engagement and rank.
   *
   * @param $array
   * @param $congresses
   * @param $kees
   * @param $kee_ids
   * @param $now
   * @return array
   */
  public function getKeeEngagementRankDetails($array, $congresses, $kee_ids, $now): array
  {
    $kee_details = [];
    if (!empty($congresses) && !empty($array)) {
      foreach ($array as $value) {
        if (in_array($value['kee_id'], $kee_ids)) {
          if (isset($value['congress']) && (in_array($value['congress'], $congresses)) || $value['calendar_date'] >= $now) {
            $kee_details['details'][$value['title'] . ' ' . $value['firstname'] . ' ' . $value['lastname']][$value['congress']][] = $value;
            $kee_details['details'][$value['title'] . ' ' . $value['firstname'] . ' ' . $value['lastname']]['kee_photo_path'] = $value['kee_photo_path'];
          }
        }
      }
      ksort($kee_details['details'], SORT_NATURAL);
      //dd($id);
    }
    return $kee_details;
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
