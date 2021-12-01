<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompletedEngagementResource;
use App\Http\Resources\EngagementResource;
use App\Http\Resources\RankResource;
use App\Models\Engagement;
use App\Models\Kee;
use App\Models\Rank;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Symfony\Component\Console\Input\Input;
use WisdomDiala\Countrypkg\Models\Country;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
      return RankResource::collection(Rank::all()->sortByDesc('created_at'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create($kee_id, Request $request)
    {
      //dd($kee_id);
      $id = htmlentities($request->input('eid'), ENT_QUOTES, 'UTF-8', false);
      $kee_id = htmlentities($kee_id, ENT_QUOTES, 'UTF-8', false);
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole( 'admin');
      if ( Auth::check() && ($is_admin || $is_super_admin)) {
        $kee = null;
        $recent_rank = null;
        if (!empty($kee_id)) {
          $kee = Kee::find($kee_id);
          $rank = Rank::where('kee_id', $kee_id)->where('attendance', '!=', 'No')->latest()->get();
          //dd($rank);
          $recent_rank = $rank->take(2)->get(0);
          $result = json_decode($recent_rank->investigator_in_study);
          $collectionA = collect($result)->filter();
          $recent_rank->investigator_in_study = $collectionA;
          //dd($recent_rank);
          if (empty($kee )) {
            return Inertia::render('LeicaComponent/Error/ItemNotFound');
          }
        }

        return Inertia::render('LeicaComponent/Rank/RankForm', [
          'kee' => $kee,
          'engagement_id' => (int) $id,
          'recent_rank' => $recent_rank,
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
    public function store(Request $request)
    {
      //dd($request);
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole('admin');
      if (Auth::check() && ($is_admin || $is_super_admin)) {
        $attendance = htmlentities($request->attendance, ENT_QUOTES, 'UTF-8', false);
        $kee_id = htmlentities($request->kee_id, ENT_QUOTES, 'UTF-8', false);
        $engagement_id = htmlentities($request->engagement_id, ENT_QUOTES, 'UTF-8', false);
        $this->rank_validation($request);
        if ($attendance == 'No') {
          $rank = Rank::create([
            'kee_id' => $kee_id,
            'engagement_id' => $engagement_id,
            'rank' => 'None',
            'understanding_data' => 'None',
            'commitment' => 'None',
            'performance_delivery' => 'None',
            'attendance' => $attendance,
          ]);
          $rank->save();
          $rank->performance_status = 'Absent';
          $rank->understanding_data_status = 'Absent';
          $rank->commitment_status = 'Absent';
          $rank->save();
        }else {
          $rank = Rank::create([
            'kee_id' => $kee_id,
            'engagement_id' => $engagement_id,
            'attendance' => $attendance,
            'flaura' => $request->flaura,
            'flaura_2' => $request->flaura_2,
            'mykonos' => $request->mykonos,
            'elios' => $request->elios,
            'savannah' => $request->savannah,
            'orchard' => $request->orchard,
            'compel' => $request->compel,
            'adaura' => $request->adaura,
            'neo_adaura' => $request->neo_adaura,
            'st1_adaura' => $request->st1_adaura,
            'target' => $request->target,
            'laura' => $request->laura,
            'is_evaluated' => $attendance == 'Yes' ? 1 : 0,
          ]);
          $rank->save();
          $this->save_rank($request, $rank);
        }
        $rank->assignKeeToRank($request->kee_id);
        $rank->save();
        return Inertia::render('LeicaComponent/Rank/RankAddEditConfirmation');
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
    public function show($id, Request $request): \Inertia\Response
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole('admin');
      if (Auth::check() && ($is_admin || $is_super_admin)) {
        $current_engagement = null;
        if (isset($id)) {
         $current_engagement = Engagement::find($id);
         if (empty($current_engagement)) {
           return Inertia::render('LeicaComponent/Error/ItemNotFound');
         }
         if (isset($current_engagement->country_id)) {
           $country = Country::find($current_engagement->country_id);
           if (!empty($country)) {
             $current_engagement->country_name = $country->name;
           }
         }
        }
        $kees = Engagement::query()->join('kees', function ($join) use ($id) {
          $join->on(function ($on) use ($id) {
            $on->whereRaw("JSON_CONTAINS(
              engagements.kee_id,
              JSON_OBJECT(\"id\",CAST(kees.id AS CHAR(50)
              )))"
              . "AND engagements.id = \"{$id}\"");
          });
        })->join('ranks', function ($join) use ($id) {
          $join->on('kees.id', '=', 'ranks.kee_id')
            ->on('ranks.id', '=', DB::raw("(SELECT MAX(id) FROM ranks WHERE ranks.kee_id = kees.id AND (ranks.engagement_id = {$id} OR ranks.engagement_id IS NULL) )"));
        })->get();
            $kees->each(function(&$kee) use ($kees) {
              if ($kee->attendance == 'No') {
                $last_rank = Rank::where('kee_id', $kee->kee_id)->where('attendance', '!=', 'No')
                  ->latest()->first();
                $kee->understanding_data_status = $last_rank->understanding_data_status ;
                $kee->commitment_status = $last_rank->commitment_status;
                $kee->performance_status = $last_rank->performance_status ;
                $kee->rank = $last_rank->rank;
              }
            });

        return Inertia::render('LeicaComponent/Rank/RankDetails', [
          'engagement' => $kees,
          'current_engagement' => $current_engagement,
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

  /**
   * Update the specified resource in storage.
   *
   * @return void
   */
    public function update()
    {
      //
    }

  /**
   * Remove the specified resource from storage.
   *
   * @param Rank $rank
   * @return \Illuminate\Http\RedirectResponse
   */
    public function delete($id)
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole( 'admin');
      if ($is_admin || $is_super_admin) {
        $rank = Rank::find($id);
        if(empty($rank)){
          return Inertia::render('LeicaComponent/Error/ItemNotFound');
        }
        if ($rank) {
          $rank->delete();

          return redirect()->back();
        }
      }
      else {
        return Inertia::render('LeicaComponent/Error/ErrorPage');
      }
    }

  /**
   * Functionality to add the ranking to the database
   *
   * @param $request
   * @param $rank
   */
  public function save_rank($request, $rank) {
      $set_value = [];
      // Get input value of understanding of data dropdown fields
      switch ($request->understanding_data) {
        case 'understanding_data_foundation' :
          $rank->understanding_data = 0;
          $rank->understanding_data_status = 'Foundation';
          $rank->save();
          $set_value[] = 0;
          break;
        case 'understanding_data_general' :
          $rank->understanding_data = 33.33;
          $rank->understanding_data_status = 'General';
          $rank->save();
          $set_value[] = 33.33;
          break;
        case 'understanding_data_advanced' :
          $rank->understanding_data = 66.66;
          $rank->understanding_data_status = 'Advanced';
          $rank->save();
          $set_value[] = 66.66;
          break;
        case 'understanding_data_expert' :
          $rank->understanding_data = 100;
          $rank->understanding_data_status = 'Expert';
          $rank->save();
          $set_value[] = 100;
          break;
      }

      // Get input value of the commitment dropdown fields
      switch ($request->commitment) {
        case 'commitment_low' :
          $rank->commitment = 0;
          $rank->commitment_status = 'Low';
          $rank->save();
          $set_value[] = 0;
          break;
        case 'commitment_medium' :
          $rank->commitment = 50;
          $rank->commitment_status = 'Medium';
          $rank->save();
          $set_value[] = 50;
          break;
        case 'commitment_high' :
          $rank->commitment = 100;
          $rank->commitment_status = 'High';
          $rank->save();
          $set_value[] = 100;
          break;
      }

      // Get input value of the performance/delivery dropdown fields
      switch ($request->performance_delivery) {
        case 'performance_delivery_foundation' :
          $rank->performance_delivery = 0;
          $rank->performance_status = 'Foundation';
          $rank->save();
          break;
        case 'performance_delivery_general' :
          $rank->performance_delivery = 33.33;
          $rank->performance_status = 'General';
          $rank->save();
          break;
        case 'performance_delivery_advanced' :
          $rank->performance_delivery = 66.66;
          $rank->performance_status = 'Advanced';
          $rank->save();
          break;
        case 'performance_delivery_expert' :
          $rank->performance_delivery = 100;
          $rank->performance_status = 'Expert';
          $rank->save();
          break;
      }
      // Get input value of the flaura clinical trial dropdown fields
      $this->clinical_trials_saved($request, $rank);
      $this->investigator_in_study($request, $rank);

      $sum = array_sum($set_value) / 4;
      $rank->overall_rank_mark = $sum;
      $rank->save();
      if ($sum == 0) {
        $rank->rank = 'D';
        $rank->overall_rank_status = 'Foundation';
        $rank->save();
      }

      if ($sum > 0 && $sum <= 25) {
        $rank->rank = 'C';
        $rank->overall_rank_status = 'General';
        $rank->save();
      }

      if ($sum > 25 && $sum < 50) {
        $rank->rank = 'B';
        $rank->overall_rank_status = 'Advanced';
        $rank->save();
      }

      if ($sum >= 50) {
        $rank->rank = 'A';
        $rank->overall_rank_status = 'Expert';
        $rank->save();
      }
      $rank->save();
    }

  /**
   * Functionality for gathering the clinical trial form fields data
   *
   * @param $request
   * @param $rank
   */
  public function clinical_trials_saved($request, $rank) {
      switch ($request->flaura) {
        case 'flaura_foundation' :
          $rank->flaura = 0;
          break;
        case 'flaura_general' :
          $rank->flaura = 33.33;
          break;
        case 'flaura_advanced' :
          $rank->flaura = 66.66;
          break;
        case 'flaura_expert' :
          $rank->flaura = 100;
          break;
      }

      switch ($request->mykonos) {
        case 'mykonos_foundation' :
          $rank->mykonos = 0;
          break;
        case 'mykonos_general' :
          $rank->mykonos = 33.33;
          break;
        case 'mykonos_advanced' :
          $rank->mykonos = 66.66;
          break;
        case 'mykonos_expert' :
          $rank->mykonos = 100;
          break;
      }
      switch ($request->elios) {
        case 'elios_foundation' :
          $rank->elios = 0;
          break;
        case 'elios_general' :
          $rank->elios = 33.33;
          break;
        case 'elios_advanced' :
          $rank->elios = 66.66;
          break;
        case 'elios_expert' :
          $rank->elios = 100;
          break;
      }
      switch ($request->savannah) {
        case 'savannah_foundation' :
          $rank->savannah = 0;
          break;
        case 'savannah_general' :
          $rank->savannah = 33.33;
          break;
        case 'savannah_advanced' :
          $rank->savannah = 66.66;
          break;
        case 'savannah_expert' :
          $rank->savannah = 100;
          break;
      }
      switch ($request->orchard) {
        case 'orchard_foundation' :
          $rank->orchard = 0;
          break;
        case 'orchard_general' :
          $rank->orchard = 33.33;
          break;
        case 'orchard_advanced' :
          $rank->orchard = 66.66;
          break;
        case 'orchard_expert' :
          $rank->orchard = 100;
          break;
      }
      switch ($request->flaura_2) {
        case 'flaura_2_foundation' :
          $rank->flaura_2 = 0;
          break;
        case 'flaura_2_general' :
          $rank->flaura_2 = 33.33;
          break;
        case 'flaura_2_advanced' :
          $rank->flaura_2 = 66.66;
          break;
        case 'flaura_2_expert' :
          $rank->flaura_2 = 100;
          break;
      }
      switch ($request->compel) {
        case 'compel_foundation' :
          $rank->compel = 0;
          break;
        case 'compel_general' :
          $rank->compel = 33.33;
          break;
        case 'compel_advanced' :
          $rank->compel = 66.66;
          break;
        case 'compel_expert' :
          $rank->compel = 100;
          break;
      }
      switch ($request->adaura) {
        case 'adaura_foundation' :
          $rank->adaura = 0;
          break;
        case 'adaura_general' :
          $rank->adaura = 33.33;
          break;
        case 'adaura_advanced' :
          $rank->adaura = 66.66;
          break;
        case 'adaura_expert' :
          $rank->adaura = 100;
          break;
      }
      switch ($request->neo_adaura) {
        case 'neo_adaura_foundation' :
          $rank->neo_adaura = 0;
          break;
        case 'neo_adaura_general' :
          $rank->neo_adaura = 33.33;
          break;
        case 'neo_adaura_advanced' :
          $rank->neo_adaura = 66.66;
          break;
        case 'neo_adaura_expert' :
          $rank->neo_adaura = 100;
          break;
      }
      switch ($request->target) {
        case 'target_foundation' :
          $rank->target = 0;
          break;
        case 'target_general' :
          $rank->target = 33.33;
          break;
        case 'target_advanced' :
          $rank->target = 66.66;
          break;
        case 'target_expert' :
          $rank->target = 100;
          break;
      }
      switch ($request->laura) {
        case 'laura_foundation' :
          $rank->laura = 0;
          break;
        case 'laura_general' :
          $rank->laura = 33.33;
          break;
        case 'laura_advanced' :
          $rank->laura = 66.66;
          break;
        case 'laura_expert' :
          $rank->laura = 100;
          break;
      }
      switch ($request->st1_adaura) {
        case 'st1_adaura_foundation' :
          $rank->st1_adaura = 0;
          break;
        case 'st1_adaura_general' :
          $rank->st1_adaura = 33.33;
          break;
        case 'st1_adaura_advanced' :
          $rank->st1_adaura = 66.66;
          break;
        case 'st1_adaura_expert' :
          $rank->st1_adaura = 100;
          break;
      }
      $rank->save();
    }

  /**
   * Implementation for the investigator checkbox.
   *
   * @param $request
   * @param $rank
   */
  public function investigator_in_study($request, $rank) {
      $study_array = [];
      $study_array[] = $request->flauraStudy ? ['flauraStudy' => 1] : '';
      $study_array[] = $request->mykonosStudy ? ['mykonosStudy' => 1] :  '';
      $study_array[] = $request->eliosStudy ? ['eliosStudy' => 1] : '';
      $study_array[] = $request->savannahStudy ? ['savannahStudy' => 1] : '';
      $study_array[] = $request->orchardStudy ? ['orchardStudy' => 1] : '';
      $study_array[] = $request->flaura2Study ? ['flaura2Study' => 1] : '';
      $study_array[] = $request->compelStudy ? ['compelStudy' => 1] : '';
      $study_array[] = $request->adauraStudy ? ['adauraStudy' => 1] : '';
      $study_array[] = $request->neoAdauraStudy ? ['neoAdauraStudy' => 1] : '';
      $study_array[] = $request->targetStudy ? ['targetStudy' => 1] : '';
      $study_array[] = $request->lauraStudy ? ['lauraStudy' => 1] : '';
      $study_array[] = $request->st1AdauraStudy ? ['st1AdauraStudy' => 1] : '';
      $rank->investigator_in_study = json_encode($study_array);
      $rank->save();
    }

  /**
   * Common validation for the Kee controller
   *
   * @param $request
   */
  public function rank_validation($request) {
    $request->validate(
      [
        'understanding_data' => $request->attendance === 'Yes' ? 'required' : '',
        'commitment' => $request->attendance === 'Yes' ? 'required' : '',
        'performance_delivery' => $request->attendance === 'Yes' ? 'required' : '',
      ]);
  }
}
