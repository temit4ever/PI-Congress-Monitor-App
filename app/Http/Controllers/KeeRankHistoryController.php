<?php

namespace App\Http\Controllers;

use App\Models\Engagement;
use App\Models\Rank;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KeeRankHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index($id, Request $request)
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole('admin');
      $is_member = auth()->user()->hasRole('member');
      if ($is_admin || $is_super_admin || $is_member) {
        $eid = htmlentities($request->eid, ENT_QUOTES, 'UTF-8', false);
        $rank_collection = Rank::where('kee_id', $id)
          ->Where('deleted_at', '=', null)
          ->latest()->get();
        if ($rank_collection->isEmpty()) {
          return Inertia::render('LeicaComponent/Error/ItemNotFound');
        }

        return Inertia::render('LeicaComponent/RankHistory',[
          'rank_collection' => $rank_collection,
          'kee_id' => $id,
          'engagement_id' => $eid,
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
