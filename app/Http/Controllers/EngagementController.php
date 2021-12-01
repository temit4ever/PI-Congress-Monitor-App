<?php

namespace App\Http\Controllers;

use App\Models\Engagement;
use App\Models\Kee;
use App\Models\Rank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use WisdomDiala\Countrypkg\Models\Country;
use WisdomDiala\Countrypkg\Models\State;

class EngagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole( 'admin');
      if ( Auth::check() && ($is_admin || $is_super_admin)) {
        $filter = htmlentities($request->filter, ENT_QUOTES, 'UTF-8', false);
        $search = htmlentities($request->search, ENT_QUOTES, 'UTF-8', false);
        $engagement = Engagement::query()
          ->orderBy('calendar_date', 'ASC');

        if ($filter == 'Filter') {
          $engagement = Engagement::query()
            ->orderBy('calendar_date', 'ASC');
        }
        if (!empty($filter) && $filter != 'Filter') {
          $engagement = $engagement->where( function($q) use ($filter) {
            $q->where("data_set", "like", "%{$filter}%");
          });
        }
          if (!empty($search)) {
            $engagement = $engagement->where(function($q) use ($search) {
              $q->where("name", "like", "%{$search}%")
                ->orWhere('city', 'like', "%{$search}%")
                ->orWhere('data_set', 'like', '%' . $search . '%');
            });
        }
        return Inertia::render('LeicaComponent/Engagement/EngagementList', [
          'engagement_list' => $engagement->paginate(10)->appends($request->query()),
          'filter_term' => $filter,
          'search_term' => $search
        ]);
      }
      else {
        return Inertia::render('LeicaComponent/Error/ErrorPage');
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole( 'admin');
      if ( Auth::check() && ($is_admin || $is_super_admin)) {
        return Inertia::render('LeicaComponent/Engagement/EngagementHeader', [
          'countries' => Country::all(),
          'cities' => State::all(),
          'kees'=> Kee::all(),
        ]);
      }
      else {
        return Inertia::render('LeicaComponent/Error/ErrorPage');
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function store(Request $request): \Inertia\Response
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole('admin');
      if (Auth::check() && $is_admin || $is_super_admin) {
        $ids = [];
        foreach ($request->kee_id as $value) {
          $ids[] = $value['id'];
        }

        $start = $request->start_time;
        $end = $request->end_time;
        if ( !empty( $start) ){
          $request->merge([
            'start_time' => "{$start['hh']}:{$start['mm']} {$start['a']}"
          ]);
        }
        if (!empty($end) ){
          $request->merge([
            'end_time' => "{$end['hh']}:{$end['mm']} {$end['a']}"
          ]);
        }

        $this->engagement_validation($request);
        $engagement = Engagement::create([
          'platform' => $request->platform,
          'name' => $request->name,
          'data_set' => $request->data_set,
          'type' => $request->type,
          'house_number' => $request->house_number,
          'address_1' => $request->address_1,
          'address_2' => $request->address_2,
          'city' => $request->city,
          'country_id' => $request->country_id,
          'post_code' => $request->post_code,
          'county_state' => $request->county_state,
          'congress' => $request->congress,
          'description' => $request->description,
          'calendar_date' => $request->calendar_date,
          'start_time' => json_encode($start),
          'end_time' => json_encode($end),
          'kee_id' => json_encode($request->kee_id),
          'digital_link' => $request->digital_link,
        ]);

        $engagement->save();
        $engagement->assignKee($ids);

        return Inertia::render('LeicaComponent/Engagement/EngagementAddEditConfirmation',
        [
          'referer' => request()->headers->get('referer')
        ]);
      }
      else {
        return Inertia::render('LeicaComponent/Error/ErrorPage');
      }
    }

  /**
   * Display the specified resource.
   *
   * @param Engagement $engagement
   * @return \Inertia\Response
   */
    public function show($id)
    {
      if(Auth::check()) {
        $engagement = Engagement::with('kees')->find($id);
        if (empty($engagement)) {
          return Inertia::render('LeicaComponent/Error/ItemNotFound');
        }

        if (!empty($engagement->country_id)) {
          $country_name = Country::find($engagement->country_id);
          $engagement->country_name = $country_name->name;
        }

        $engagement = KEE::query()->join('engagements', function ($join) use ($id) {
          $join->on(function ($on) use ($id) {
            $on->whereRaw("JSON_CONTAINS(
              engagements.kee_id,
              JSON_OBJECT(\"id\",CAST(kees.id AS CHAR(50)
              )))"
              . "AND engagements.id = \"{$id}\"");
          });
        })->join('ranks', function ($join) {
          $join->on('kees.id', '=', 'ranks.kee_id')
            ->on('ranks.id', '=', DB::raw("(SELECT MAX(id) FROM ranks WHERE ranks.kee_id = kees.id)"));
        })->get();

        $current_engagement = '';
        if (isset($id)) {
          $current_engagement = Engagement::find($id);
          if (empty($current_engagement)) {
            return Inertia::render('LeicaComponent/Error/ItemNotFound');
          }
        }
        if (isset($current_engagement->country_id)) {
          $country = Country::find($current_engagement->country_id);
          if (!empty($country)) {
            $current_engagement->country_name = $country->name;
          }
        }

        //foreach ($engagement as $absent_kees) {
          //if ($absent_kees->attendance == 'No') {

            //$last_rank = $rank->take(2)->get(1);
            $engagement->each(function (&$kee) {
              if ($kee->attendance == 'No') {
                $last_rank = Rank::where('kee_id', $kee->kee_id)->where('attendance', '!=', 'No')->latest()->get();
                $kee->understanding_data_status = $last_rank[0]->understanding_data_status;
                $kee->commitment_status = $last_rank[0]->commitment_status;
                $kee->performance_status = $last_rank[0]->performance_status;
                $kee->rank = $last_rank[0]->rank;
              }
            });
          //}
        //}

        //$engagement->ranking_detail = collect($rank)->filter()->all();
        return Inertia::render('LeicaComponent/Engagement/EngagementDetails',[
          'engagement' => $engagement,
          'current_engagement' => $current_engagement
        ]);
      }
      else {
        return Inertia::render('LeicaComponent/Error/ErrorPage');
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole('admin');
      if ($is_admin || $is_super_admin) {
        if (isset($id)) {
          $engagement = Engagement::find($id);
          if (!empty($engagement)){
            return Inertia::render('LeicaComponent/Engagement/EngagementEditForm', [
              'engagement' => $engagement,
              'countries' => Country::all(),
              'cities' => State::all(),
              'kees' => Kee::all(),
            ]);
          }
          else {
            return Inertia::render('LeicaComponent/Error/ItemNotFound');
          }
        }
      }
      else {
        return Inertia::render('LeicaComponent/Error/ErrorPage');
      }
    }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param Engagement $engagement
   * @return \Inertia\Response
   */
    public function update(Request $request)
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole('admin');
      if ($is_admin || $is_super_admin) {
        $ids = [];
        foreach ($request->kee_id as $value) {
          $ids[] = $value['id'];
        }
        // Todo: to be look at later.
       /* $start = $request->start_time;
        $end = $request->end_time;
        if ( !empty( $start) ){
          $request->merge([
            'start_time' => "{$start['hh']}:{$start['mm']} {$start['a']}"
          ]);
        }
        if (!empty($end) ){
          $request->merge([
            'end_time' => "{$end['hh']}:{$end['mm']} {$end['a']}"
          ]);
        }*/
        $this->engagement_validation($request);
        $engagement = Engagement::find($request->id);
        $engagement->update([
          'platform' => $request->platform,
          'name' => $request->name,
          'data_set' => $request->data_set,
          'type' => $request->type,
          'house_number' => $request->house_number,
          'address_1' => $request->address_1,
          'address_2' => $request->address_2,
          'city' => $request->city,
          'country_id' => $request->country_id,
          'post_code' => $request->post_code,
          'county_state' => $request->county_state,
          'congress' => $request->congress,
          'description' => $request->description,
          'calendar_date' => $request->calendar_date,
          'start_time' => json_encode($request->start_time),
          'end_time' => json_encode($request->end_time),
          'digital_link' => $request->digital_link,
        ]);
        $engagement->kee_id = $request->kee_id;
        $engagement->save();
        $engagement->kees()->sync($ids);
        return Inertia::render('LeicaComponent/Engagement/EngagementAddEditConfirmation', [
          'referer' => request()->headers->get('referer')
        ]);
      }
      else {
        return Inertia::render('LeicaComponent/Error/ErrorPage');
      }
    }

  /**
   * Remove the specified resource from storage.
   *
   * @param Engagement $engagement
   * @return \Illuminate\Http\RedirectResponse
   */
    public function delete($id)
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole( 'admin');
      if ($is_admin || $is_super_admin) {
        $engagement = Engagement::find($id);
        if ($engagement) {
          $engagement->ranks()->delete();
          $engagement->delete();

          return redirect()->back();
        }
      }
      else {
        return Inertia::render('LeicaComponent/Error/ErrorPage');
      }
    }

  /**
   * Common validation for the Engagement controller
   *
   * @param $request
   */
  public function engagement_validation($request) {
      $request->validate(
        [
        'platform' => 'required',
        'name' => 'required',
        'data_set' => 'required',
        'type' => 'required',
        //'country_id' => 'required',
        'calendar_date' => 'required',
          /*'start_time' => empty($request->start_time) ? '' : 'bail',
          'end_time' =>  empty($request->end_time) ? '' : 'bail|after:start_time',*/
        'kee_id' => 'required'
      ],
        /*[
          'digital_link.url' => $request->data_link ? "Please enter a valid URL." : '',
          'start_time.date_format' => $request->start_time ? "Please enter a valid time." : '',
          'end_time.date_format' => $request->end_time ? "Please enter a valid time." : '',
          'end_time.after' => "The start time must be before the end time."
        ]*/
      );
    }
}
