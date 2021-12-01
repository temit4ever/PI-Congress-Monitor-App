<?php

namespace App\Http\Controllers;

use App\Models\Engagement;
use App\Models\Kee;
use Illuminate\Http\Request;
use Inertia\Inertia;
use WisdomDiala\Countrypkg\Models\Country;
use WisdomDiala\Countrypkg\Models\State;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(Request $request)
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole('admin');
      if ($is_admin || $is_super_admin) {
        $kee = null;
        if($request->id) {
          $kee = Kee::find($request->id);
            if(!$kee) {
              return Inertia::render('LeicaComponent/Error/ItemNotFound');
            }
        }

        return Inertia::render('LeicaComponent/Schedule', [
          'countries' => Country::all(),
          'cities' => State::all(),
          'kees' => Kee::all(),
          'kee' => $kee
        ]);
      }
      else {
        return Inertia::render('LeicaComponent/Error/ErrorPage');
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function store(Request $request)
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole('admin');
      if ($is_admin || $is_super_admin) {
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
        if ( !empty($end) ){
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

        return Inertia::render('LeicaComponent/ScheduleAddConfirmation',
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
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show(Request $request)
    {

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
        'digital_link' => 'nullable|url',
        'calendar_date' => 'required',
        //'start_time' => 'bail|required|date_format:h:i a',
        //'end_time' => 'bail|required|date_format:h:i a|after:start_time',
        'kee_id' => 'required'
      ],
    [
      /*'digital_link.url' => "Please enter a valid URL.",
      'start_time.date_format' => "Please enter a valid time.",
      'end_time.date_format' => "Please enter a valid time.",
      'end_time.after' => "The start time must be before the end time."*/
    ]);
  }
}
