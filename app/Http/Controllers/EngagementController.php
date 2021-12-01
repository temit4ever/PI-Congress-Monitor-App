<?php

namespace App\Http\Controllers;

use App\Http\Resources\EngagementResource;
use App\Models\Engagement;
use App\Models\Kee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\In;
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
    public function index(Request $request, Engagement $engagement)
    {
      if(Auth() && auth()->user()->hasRole(['super-admin', 'admin'])) {
        //$term = trim($request->query('term'));

        //$date = ->format('d/m/Y');
        //dd($date);
        $term = trim($request->search_term);
        if (!empty($term)) {
          //  Engagement::with('kees')->whereDate('calendar_date', $term)
          $engagement = Engagement::with('kees')->Where('city', 'LIKE', '%' . $term) // Search by Location
          ->orWhere('name', 'LIKE', '%' . $term) // Search by Engagement name
          ->paginate(10);
          $eng = EngagementResource::collection($engagement)->sortBy('created_at', SORT_DESC, true);
        } else {
          $eng = Engagement::with('kees')->paginate(10);

        }

        $result = EngagementResource::collection($eng->sortByDesc('created_at'));
        return Inertia::render('LeicaComponent/Engagement/EngagementList', ['engagements' => $result]);
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
      if(Auth() && auth()->user()->hasRole(['super-admin', 'admin', 'member'])) {
        return Inertia::render('LeicaComponent/Engagement/EngagementForm', [
          'countries' => Country::all(),
          'cities' => State::all(),
          'kees'=> Kee::all(),
        ]);
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
      //dd(json_encode($request->kee_id));
      //dd(json_encode($request->end_time));
      $ids = [];
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
        'post_code' => $request->post_code,
        'county_state' => $request->county_state,
        'congress_link' => $request->congress_link,
        'description' => $request->description,
        'calendar_date' => $request->calendar_date,
        'start_time' => json_encode($request->start_time),
        'end_time' => json_encode($request->end_time),
        'kee_id' => json_encode($request->kee_id),
        'digital_link' => $request->digital_link,
      ]);

      $engagement->save();
      $engagement->assignKee($ids);

      return Inertia::render('LeicaComponent/Engagement/EngagementList');
    }

  /**
   * Display the specified resource.
   *
   * @param Engagement $engagement
   * @return EngagementResource
   */
    public function show(Engagement $engagement)
    {
      //dd($engagement);
      //$res = Engagement::where('city','LIKE','%'.$engagement.'%')->get();
        return new EngagementResource($engagement);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param Engagement $engagement
   * @return EngagementResource
   */
    public function update(Request $request, Engagement $engagement)
    {
      $this->engagement_validation($request);
      $engagement->update($request->all());
      return new EngagementResource($engagement);
    }

  /**
   * Remove the specified resource from storage.
   *
   * @param Engagement $engagement
   * @return void
   */
    public function destroy(Engagement $engagement)
    {
        $engagement->delete();
    }

  /**
   * Common validation for the Engagement controller
   *
   * @param $request
   */
  public function engagement_validation($request) {
      $request->validate(
        [
        'platform' => 'required|string|max:20',
        'name' => 'required|string',
        'data_set' => 'required|in:early,late,both',
        'type' => 'required|string',
        'house_number' => 'required|integer|min:1|max:10',
        'address_1' => 'required|string',
        'address_2' => 'string',
        'city' => 'required',
        'post_code' => 'required',
        'county_state' => 'required',
        'country_id' => 'required',
        'congress_link' => 'required',
        'description' => 'required',
        'calendar_date' => 'required|data',
        'start_time' => 'required|date_format:h:i A',
        'end_time' => 'required|date_format:h:i A|after_or_equal:start_time',
        'kee_ids' => 'required'
      ]);
    }
}
