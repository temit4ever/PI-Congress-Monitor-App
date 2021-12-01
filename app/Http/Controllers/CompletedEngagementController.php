<?php

namespace App\Http\Controllers;

use App\Http\Resources\EngagementResource;
use App\Models\Engagement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CompletedEngagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole('admin');
      if (Auth::check() && ($is_admin || $is_super_admin)) {
        $completed = Engagement::whereDate('calendar_date', '<', Carbon::now())->orderBy('calendar_date', 'ASC')
          ->with('kees')
          ->latest()->paginate(10)->appends($request->all());
        //dd($completed);
        return Inertia::render('LeicaComponent/Rank/RankList', [
          'completed_list' => $completed
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
     * @return \Inertia\Response
     */
    public function delete($id)
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole( 'admin');
      if ($is_admin || $is_super_admin) {
        if (isset($id)){
          $engagement = Engagement::find($id);
          if (empty($engagement)) {
            return Inertia::render('LeicaComponent/Error/ItemNotFound');
          }
          $engagement->delete();
          return redirect()->back();
        }
        else {
          return Inertia::render('LeicaComponent/Error/ItemNotFound');
        }
      }
      else {
        return Inertia::render('LeicaComponent/Error/ErrorPage');
      }
    }
}
