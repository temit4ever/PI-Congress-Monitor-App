<?php

namespace App\Http\Controllers;

use App\Http\Resources\KeeResource;
use App\Models\Engagement;
use App\Models\Kee;
use App\Models\Rank;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use WisdomDiala\Countrypkg\Models\Country;
use WisdomDiala\Countrypkg\Models\State;


class KeeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Inertia\Response
   */
  public function index(Request $request, Kee $kee): \Inertia\Response
  {
   // dd($request->query());
    $is_super_admin = auth()->user()->hasRole('super-admin');
    $is_admin = auth()->user()->hasRole('admin');
    if (Auth::check() && ($is_admin || $is_super_admin)) {

      $filter = htmlentities($request->filterTerm, ENT_QUOTES, 'UTF-8', false);
      $search = htmlentities($request->term, ENT_QUOTES, 'UTF-8', false);

      $kees = KEE::query()
        ->leftJoin('ranks', function ($join) {
          $join->on('kees.id', '=', 'ranks.kee_id')
            ->on('ranks.id', '=', DB::raw("(SELECT MAX(id) FROM ranks WHERE ranks.kee_id = kees.id AND ranks.attendance != 'No'
              AND ranks.deleted_at is null)"));
        })->select('kees.*',
          'ranks.id AS rid',
          'ranks.rank',
          'ranks.commitment_status',
          'ranks.understanding_data_status',
          'ranks.performance_status'
        )->orderByRaw("kees.created_at DESC");

      if ($filter && $filter != 'Filter') {
        $kees = $kees->where('specialism', "=", $filter);
      }

      if ($search && !empty($search)) {
        $kees = $kees->where(function ($query) use ($search) {
          $query->where('firstname', "LIKE", "%{$search}%")
            ->orWhere('lastname', 'LIKE', "%{$search}%")
            ->orWhere('place_of_work', 'LIKE', "%{$search}%");
        });
      }
      return Inertia::render('LeicaComponent/Kee/KeeList', [
        'kee_lists' => $kees->with('engagements')->latest()->paginate(10)->appends($request->query()),
        'countries' => Country::all(),
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
    if (Auth::check() && ($is_admin || $is_super_admin)) {
      return Inertia::render('LeicaComponent/Kee/KeeForm', [
        'countries' => Country::all(),
        'cities' => State::all(),
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
   * @param Kee $kee
   * @return \Inertia\Response
   */
  public function store(Request $request): \Inertia\Response
  {
    //dd($request);
    $is_super_admin = auth()->user()->hasRole('super-admin');
    $is_admin = auth()->user()->hasRole( 'admin');
    if (Auth::check() && ($is_admin || $is_super_admin)) {
      $this->kee_validation($request);
     $country_name = Country::find($request->country_id);
     if(empty($country_name)) {
       return Inertia::render('LeicaComponent/Error/ItemNotFound');
     }

      $kee = Kee::create([
        'user_id' => $request->user_id,
        'title' => $request->title,
        'firstname' => $request->firstname,
        'lastname' => $request->lastname,
        'email' => $request->email,
        'place_of_work' => $request->place_of_work,
        'country_id' => $request->country_id,
        'city' => $request->city,
        'country' => $country_name->name,
        'specialism' => $request->specialism,
        'h1_link' => $request->h1_link,
        'kee_photo_path' => $request->avatar
      ]);

      $kee->user_id = Auth::id();
      $kee->save();
      if ($request->hasFile('avatar')) {
        $kee->addMediaFromRequest('avatar')
          ->toMediaCollection();
        $kee->kee_photo_path = $kee->getFirstMedia()->getUrl();
        $kee->save();
      }

      $rank = Rank::create([
        'kee_id' => $kee->id,
        'understanding_data' => 0,
        'attendance'=> 'Default',
        'commitment' => 50,
        'performance_delivery' => 0,
      ]);

      if ($request->understanding_data || $request->commitment || $request->performance_delivery) {
        $this->extracted($request, $rank);
      }
      else {
        $rank->save();
        $rank->rank ='D';
        $rank->overall_rank_mark = 0;
        $rank->overall_rank_status = 'Foundation';
        $rank->performance_status = 'Foundation';
        $rank->understanding_data_status = 'Foundation';
        $rank->commitment_status = 'Medium';
        $rank->flaura = 0;
      }
      $rank->save();
      $rank->assignKeeToRank($kee['id']);
      $rank->save();
      return Inertia::render('LeicaComponent/Kee/KeeAddEditConfirmation');
    }
    else {
      return Inertia::render('LeicaComponent/Error/ErrorPage');
    }
  }


  /**
   * Display the specified resource.
   *
   * @param $id
   * @return \Inertia\Response
   */
  public function show($id, Request  $request): \Inertia\Response
  {
    $is_super_admin = auth()->user()->hasRole('super-admin');
    $is_admin = auth()->user()->hasRole('admin');
    $is_member = auth()->user()->hasRole('member');
    if ($is_admin || $is_super_admin || $is_member) {
      $eid = htmlentities($request->eid, ENT_QUOTES, 'UTF-8', false);
      if (!empty($id)) {
        $kee = Kee::find($id);
        if (empty($kee )) {
          return Inertia::render('LeicaComponent/Error/ItemNotFound');
        }
      }

      $rank = Rank::where('kee_id', $id)->where('attendance', '!=', 'No')->latest()->get();
      $engagement = Engagement::whereJsonContains('kee_id', ['id' => $id])->get();
      $engagement = $engagement->get(0);
      // Get the most recent ranking of a kee
      $recent_rank = $rank->take(3)->get(0);
      $result = json_decode($recent_rank->investigator_in_study);
      $collectionA = collect($result)->filter();
      $recent_rank->investigator_in_study = $collectionA;

      // Get the previous ranking of a kee
      $last_rank = $rank->take(3)->get(1);
       return Inertia::render('LeicaComponent/Kee/KeeDetails',[
         'kee' => $kee,
         'last_rank' => $last_rank,
         'recent_rank' => $recent_rank,
         'engagement' => $engagement,
         ]);
    }
    else {
      return Inertia::render('LeicaComponent/Error/ErrorPage');
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return \Inertia\Response
   */
  public function edit(int $id): \Inertia\Response
  {
    $is_super_admin = auth()->user()->hasRole('super-admin');
    $is_admin = auth()->user()->hasRole( 'admin');
    if ($is_admin || $is_super_admin) {
      if (!empty($id)) {
        // Get Kee based on attendance and associated engagements
        $kees = Kee::query()
          ->Join('ranks', function ($join) use ($id) {
            $join->on('ranks.kee_id', '=', 'kees.id')
              ->where('kees.id', '=', $id)
              ->on('ranks.id', '=', DB::raw("(SELECT MAX(id) FROM ranks WHERE ranks.kee_id = kees.id AND (ranks.attendance = 'Default') )"));
          })->orderBy('ranks.id', 'DESC')->first();
        if (empty($kees)) {
          return Inertia::render('LeicaComponent/Error/ItemNotFound');
        }
      }

      return Inertia::render('LeicaComponent/Kee/KeeEditForm', [
        'kee' => $kees,
        'countries' => Country::all(),
        'cities' => State::all(),
      ]);
    }
    else {
      return Inertia::render('LeicaComponent/Error/ErrorPage');
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param Kee $kee
   * @return \Inertia\Response
   * @throws ValidationException
   */
  public function update(Request $request)
  {
    $is_super_admin = auth()->user()->hasRole('super-admin');
    $is_admin = auth()->user()->hasRole( 'admin');
    if ($is_admin || $is_super_admin) {
    $this->kee_validation($request);
      $update = Kee::find($request->kee_id);
      $update_rank = Rank::find($request->id);
      $country_name = Country::find($request->country_id);
      if (empty($update) || empty($country_name) || empty($update_rank)) {
        return Inertia::render('LeicaComponent/Error/ItemNotFound');
      }
      if (!empty($request->understanding_data) || $request->commitment || $request->performance_delivery) {
        $update_rank->update($request->only([
          'understanding_data_status',
          'commitment_status',
          'performamce_status',
        ]));

        $this->extracted($request, $update_rank);
      }

      $update->update($request->only([
        'title',
        'firstname',
        'lastname',
        'email',
        'place_of_work',
        'country',
        'city',
        'kee_photo_path',
        'h1_link',
        'specialism',
        'country_id',
      ]));
      $update->update($request->all());
      $update->country = $country_name->name;
      $update->user_id = Auth::id();
      $update->save();
      if ($request->hasFile('avatar')) {
        $update->clearMediaCollection('media');
        $update->addMedia($request->avatar)->toMediaCollection('media');
        $update->kee_photo_path =  $update->getFirstMedia('media')->getUrl();
        $update->save();
      }

    return Inertia::render('LeicaComponent/Kee/KeeAddEditConfirmation');
  }
    else {
      return Inertia::render('LeicaComponent/Error/ErrorPage');
    }
}

  /**
   * Remove the specified resource from storage.
   *
   * @param Kee $kee
   * @return \Illuminate\Http\RedirectResponse
   */
    public function delete($id)
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole( 'admin');
      if ($is_admin || $is_super_admin) {
        $kee = Kee::find($id);
        if ($kee) {
          $kee->ranks()->delete();
          $kee->delete();
          return Redirect::route('manage_kee.index');
        }
      }
      else {
        return Inertia::render('LeicaComponent/Error/ErrorPage');
      }
    }

  /**
   * Common validation for the Kee controller
   *
   * @param $request
   */
  public function kee_validation($request) {
    $request->validate(
      [
        'title' => 'required|min:2|max:20',
        'firstname' => 'required|min:2|max:20',
        'lastname' => 'required|min:2|max:20',
        'email' => $request->email ? 'email:rfc,filter,dns' : '',
        'country_id' => 'required',
        'h1_link' => 'required|url',
        'specialism' => 'required',
      ]);
  }

  /**
   * @param Request $request
   * @param $update_rank
   */
  public function extracted(Request $request, $update_rank): void
  {
    $set_value = [];
    switch ($request->understanding_data) {
      case 'understanding_data_foundation' :
        $update_rank->understanding_data = 0;
        $update_rank->understanding_data_status = 'Foundation';
        $update_rank->save();
        $set_value[] = 0;
        break;
      case 'understanding_data_general' :
        $update_rank->understanding_data = 33.33;
        $update_rank->understanding_data_status = 'General';
        $update_rank->save();
        $set_value[] = 33.33;
        break;
      case 'understanding_data_advanced' :
        $update_rank->understanding_data = 66.66;
        $update_rank->understanding_data_status = 'Advanced';
        $update_rank->save();
        $set_value[] = 66.66;
        break;
      case 'understanding_data_expert' :
        $update_rank->understanding_data = 100;
        $update_rank->understanding_data_status = 'Expert';
        $update_rank->save();
        $set_value[] = 100;
        break;
    }

    // Get input value of the commitment dropdown fields
    switch ($request->commitment) {
      case 'commitment_low' :
        $update_rank->commitment = 0;
        $update_rank->commitment_status = 'Low';
        $update_rank->save();
        $set_value[] = 0;
        break;
      case 'commitment_medium' :
        $update_rank->commitment = 50;
        $update_rank->commitment_status = 'Medium';

        $update_rank->save();
        $set_value[] = 50;
        break;
      case 'commitment_high' :
        $update_rank->commitment = 100;
        $update_rank->commitment_status = 'High';
        $update_rank->save();
        $set_value[] = 100;
        break;
    }

    // Get input value of the performance/delivery dropdown fields
    switch ($request->performance_delivery) {
      case 'performance_delivery_foundation' :
        $update_rank->performance_delivery = 0;
        $update_rank->performance_status = 'Foundation';
        $update_rank->save();
        break;
      case 'performance_delivery_general' :
        $update_rank->performance_delivery = 33.33;
        $update_rank->performance_status = 'General';
        $update_rank->save();
        break;
      case 'performance_delivery_advanced' :
        $update_rank->performance_delivery = 66.66;
        $update_rank->performance_status = 'Advanced';
        $update_rank->save();
        break;
      case 'performance_delivery_expert' :
        $update_rank->performance_delivery = 100;
        $update_rank->performance_status = 'Expert';
        $update_rank->save();
        break;
    }
    $sum = array_sum($set_value) / 4;
    $update_rank->overall_rank_mark = $sum;
    $update_rank->save();
    if ($sum == 0) {
      $update_rank->rank = 'D';
      $update_rank->overall_rank_status = 'Foundation';
      $update_rank->save();
    }
    if ($sum > 0 && $sum <= 25) {
      $update_rank->rank = 'C';
      $update_rank->overall_rank_status = 'General';
      $update_rank->save();
    }
    if ($sum > 25 && $sum < 50) {
      $update_rank->rank = 'B';
      $update_rank->overall_rank_status = 'Advanced';
      $update_rank->save();
    }
    if ($sum >= 50) {
      $update_rank->rank = 'A';
      $update_rank->overall_rank_status = 'Expert';
      $update_rank->save();
    }
  }
}
