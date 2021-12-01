<?php

namespace App\Http\Controllers;

use App\Models\Engagement;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Pagination\LengthAwarePaginator;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request, Engagement $engagement): \Inertia\Response
    {
      if (Auth::check()) {
        $calendar = null;
        $filter = htmlentities($request->filter, ENT_QUOTES, 'UTF-8', false);
        $search = htmlentities($request->search, ENT_QUOTES, 'UTF-8', false);

        $calendar = Engagement::query()
          ->orderBy('calendar_date', 'ASC');

        if ( !empty($filter) && $filter !== "Filter By Month" ) {
          $calendar = $calendar->whereRaw("MONTH(calendar_date) = {$filter}");
        } else {
          $filter = 0;
        }

        if ( !empty($search) ) {
          $calendar = $calendar->where(function($q) use ($search) {
            $q->where("name", "LIKE", "%{$search}%")
              ->orWhere("city", "LIKE", "%{$search}%")
              ->orWhere("data_set", "LIKE", "%{$search}%");

          });
        }

        $calendar = $calendar->get()->groupBy(function ($v) {
          return Carbon::parse($v->calendar_date)->format('F Y');
        });
        return Inertia::render('LeicaComponent/Calendar', [
          'engagement_calendar' => $calendar,
          'filter' => $filter,
          'search' => $search
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
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete()
    {
      //
    }
}
