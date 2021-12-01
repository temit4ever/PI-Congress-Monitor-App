<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompletedEngagementResource;
use App\Http\Resources\EngagementResource;
use App\Http\Resources\RankResource;
use App\Models\Engagement;
use App\Models\Rank;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

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
     * @return RankResource
     */
    public function store(Request $request)
    {
      $this->rank_validation($request);
       $rank = Rank::create([
        'understanding_data' => $request->understanding_data,
        'commitment' => $request->commitment,
        'performance_delivery' => $request->performance_delivery,
         'kee_id' => $request->kee_id, // Create an hidden input form and pass the current kee id
        'fluara' => $request->fluara,
        'fluara_2' => $request->fluara_2,
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
      ]);

       $input_1 = $request->understanding_data;
       $input_2 = $request->commitment;
       $input_3 = $request->performance_delivery;

      $set_value = [];
      // Get input value of understanding of data dropdown fields
      switch ($input_1) {
        case 'understanding_data_general' :
          $rank->understanding_data = 'General';
          $set_value[] = 1;
          break;
        case 'understanding_data_basic' :
          $rank->understanding_data = 'Basic';
          $set_value[] = 2;
          break;
        case 'understand_data_advance' :
          $rank->understanding_data = 'Advance';
          $set_value[] = 3;
          break;
        case 'understand_data_expert' :
          $rank->understanding_data = 'Expert';
          $set_value[] = 4;
          break;
      }

      // Get input value of the commitment dropdown fields
      switch ($input_2) {
        case 'commitment_low' :
          $rank->commitment = 'Low';
          $set_value[] = 1;
          break;
        case 'commitment_medium' :
          $rank->commitment = 'Medium';
          $set_value[] = 2;
          break;
        case 'commitment_high' :
          $rank->commitment = 'High';
          $set_value[] = 3;
          break;
      }

      // Get input value of the performance/delivery dropdown fields
      switch ($input_3) {
        case 'performance_delivery_basic' :
          $rank->performance_delivery = 'Basic';
          $set_value[] = 1;
          break;
        case 'performance_delivery_general' :
          $rank->performance_delivery = 'General';
          $set_value[] = 2;
          break;
        case 'performance_delivery_advance' :
          $rank->performance_delivery = 'Advance';
          $set_value[] = 3;
          break;
        case 'performance_delivery_expert' :
          $rank->performance_delivery = 'Expect';
          $set_value[] = 4;
          break;
      }

      $sum = array_sum($set_value);
      if ($sum <= 5) {
        $rank->rank = 'C';
      }

      if ($sum > 5 && $sum <= 8) {
        $rank->rank = 'B';
      }

      if ($sum > 8 && $sum <= 11) {
        $rank->rank = 'A';
      }

      $rank->save();

      return new RankResource($rank);
    }

  /**
   * Display the specified resource.
   *
   * @param Engagement $engagement
   * @return RankResource
   */
    public function show($id): RankResource
    {
      $rank = Rank::find($id);
      return new RankResource($rank);
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
     * @return RankResource
     */
    public function update(Request $request, Rank $rank): RankResource
    {
      $this->rank_validation($request);
      $rank->update($request->all());

      $input_1 = $request->understanding_data;
      $input_2 = $request->commitment;
      $input_3 = $request->performance_delivery;

      $set_value = [];
      // Get input value of understanding of data dropdown fields
      switch ($input_1) {
        case 'understanding_data_general' :
          $rank->understanding_data = 'General';
          $set_value[] = 1;
          break;
        case 'understanding_data_basic' :
          $rank->understanding_data = 'Basic';
          $set_value[] = 2;
          break;
        case 'understand_data_advance' :
          $rank->understanding_data = 'Advance';
          $set_value[] = 3;
          break;
        case 'understand_data_expert' :
          $rank->understanding_data = 'Expert';
          $set_value[] = 4;
          break;
      }

      // Get input value of the commitment dropdown fields
      switch ($input_2) {
        case 'commitment_low' :
          $rank->commitment = 'Low';
          $set_value[] = 1;
          break;
        case 'commitment_medium' :
          $rank->commitment = 'Medium';
          $set_value[] = 2;
          break;
        case 'commitment_high' :
          $rank->commitment = 'High';
          $set_value[] = 3;
          break;
      }

      // Get input value of the performance/delivery dropdown fields
      switch ($input_3) {
        case 'performance_delivery_basic' :
          $rank->performance_delivery = 'Basic';
          $set_value[] = 1;
          break;
        case 'performance_delivery_general' :
          $rank->performance_delivery = 'General';
          $set_value[] = 2;
          break;
        case 'performance_delivery_advance' :
          $rank->performance_delivery = 'Advance';
          $set_value[] = 3;
          break;
        case 'performance_delivery_expert' :
          $rank->performance_delivery = 'Expect';
          $set_value[] = 4;
          break;
      }

      $sum = array_sum($set_value);
      if ($sum <= 5) {
        $rank->rank = 'C';
      }

      if ($sum > 5 && $sum <= 8) {
        $rank->rank = 'B';
      }

      if ($sum > 8 && $sum <= 11) {
        $rank->rank = 'A';
      }

      $rank->save();

      return new RankResource($rank);

    }

  /**
   * Remove the specified resource from storage.
   *
   * @param Rank $rank
   * @return \Illuminate\Http\Response
   */
    public function destroy(Rank $rank)
    {
        $rank->delete();
    }

  /**
   * Common validation for the Kee controller
   *
   * @param $request
   */
  public function rank_validation($request) {
    $request->validate(
      [
        'understanding_data' => 'required|string',
        'commitment' => 'required|string',
        'performance_delivery' => 'required|string',
        'fluara' => 'string',
        'mykonos' => 'string',
        'elios' => 'string',
        'savannah' => 'string',
        'orchard' => 'string',
        'flaura-2' => 'string',
        'compel' => 'string',
        'adaura' => 'string',
        'neo_adaura' => 'string',
        'st1_adaura' => 'string',
        'target' => 'string',
        'laura' => 'string',
        'rank' => 'string',
        'overall' => 'string',
      ]);
  }
}
