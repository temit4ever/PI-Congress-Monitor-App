<?php

namespace App\Http\Controllers;

use App\Http\Resources\CalendarResource;
use App\Http\Resources\EngagementResource;
use App\Models\Engagement;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request, Engagement $engagement): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
      // Filtering by Month
      $term = trim($request->search_term);
      if (!empty($term)) {
        $engagement = Engagement::whereMonth('calendar_date', $term)
          ->orWhere('city', 'LIKE', '%' . $term ) // Search by Location
          ->orWhere('name', 'LIKE', '%' . $term) // Search by Engagement name
          ->paginate(10);
        $eng = CalendarResource::collection($engagement)->sortBy('created_at', SORT_DESC, true);
      }
      else {
        $eng = Engagement::with('kees')->paginate(7);
      }

      return CalendarResource::collection($eng->sortByDesc('created_at'));
      //return Inertia::render('LeicaComponent/Engagement/Calendar', [$eng]);
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
