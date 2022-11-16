<?php

namespace App\Http\Controllers;

use App\Models\Kee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use WisdomDiala\Countrypkg\Models\Country;

class ClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
      if (Auth::check()) {
        $rank_term = htmlentities($request->rank, ENT_QUOTES, 'UTF-8', false);
        $performance = htmlentities($request->performanceTerm, ENT_QUOTES, 'UTF-8', false);
        $commitment = htmlentities($request->commitmentTerm, ENT_QUOTES, 'UTF-8', false);
        $specialism = htmlentities($request->specialismTerm, ENT_QUOTES, 'UTF-8', false);
        $country = htmlentities($request->countryTerm, ENT_QUOTES, 'UTF-8', false);
        $search = htmlentities($request->kee_search_term, ENT_QUOTES, 'UTF-8', false);

        $kees = KEE::query()
          ->leftJoin('ranks', function ($join) {
            $join->on('kees.id', '=', 'ranks.kee_id')
              ->on('ranks.id', '=', DB::raw("(SELECT MAX(id) FROM ranks WHERE ranks.kee_id = kees.id AND ranks.attendance != 'No'
              AND ranks.deleted_at is null)"));
          })->select('kees.*',
            'ranks.id AS eid',
            'ranks.rank',
            'ranks.commitment_status',
            'ranks.understanding_data_status',
            'ranks.performance_status'
          )->orderByRaw("kees.created_at DESC");

        if ($rank_term && $rank_term != 'Classification') {
          $kees = $kees->where('ranks.rank', "=", $rank_term);
        }

        if ($commitment && $commitment != 'Commitment') {
          $kees = $kees->where('ranks.commitment_status', "=", $commitment);
        }

        if ($performance && $performance != 'Performance') {
          $kees = $kees->where('ranks.performance_status', "=", $performance);
        }

        if ($specialism && $specialism != 'Specialism') {
          $kees = $kees->where('kees.specialism', "=", $specialism);
        }

        if ($country && $country != 'Country') {
          $kees = $kees->where('kees.country', "=", $country);
        }

        if ($search && !empty($search)) {
          $kees = $kees->where(function ($query) use ($search) {
            $query->where('kees.firstname', "LIKE", "%{$search}%")
              ->orWhere('kees.lastname', 'LIKE', "%{$search}%")
              ->orWhere('kees.title', 'LIKE', "%{$search}%");
          });
        }

        $kees = $kees->paginate(15);

        return Inertia::render('LeicaComponent/Classification', [
          'kee_rank' => $kees->appends($request->query()),
          'countries' => Country::all(),
          'filter_rank' => $rank_term,
          'filter_performance' => $performance,
          'filter_commitment' => $commitment,
          'filter_specialism' => $specialism,
          'filter_country' => $country,
          'kee_search_term' => $search,
          'filter' => collect($kees->items())->filter()->all(),
        ]);


      }
      else {
        return Inertia::render('LeicaComponent/Error/ErrorPage');
      }
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
