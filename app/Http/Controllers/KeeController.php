<?php

namespace App\Http\Controllers;

use App\Http\Resources\KeeResource;
use App\Models\Kee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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
  public function index(Request $request): \Inertia\Response
  {
    if (Auth() && auth()->user()->hasRole(['super-admin', 'admin', 'member'])) {
      $term = trim($request->query('term'));

      if (!empty($term)) {
        $result = Kee::where('firstname', 'LIKE', '%' . $term . '%')
          ->orWhere('lastname', 'LIKE', '%' . $term . '%')
          ->orWhere('city', 'LIKE', '%' . $term . '%')
          ->orWhere('specialism', 'LIKE', '%' . $term . '%')
          ->orWhere('country_id', 'LIKE', '%' . $term . '%')->get();
        $kee = keeResource::collection($result->sortByDesc('created_at'));
      } else {
        $kee = KeeResource::collection(Kee::all()->sortByDesc('created_at'));
      }

      return Inertia::render('LeicaComponent/Kee/KeeList', [
        'kee_lists' => $kee,
        'countries' => Country::all(),
      ]);
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Inertia\Response
   */
  public function create()
  {
    $perm = auth()->user()->hasRole(['super-admin', 'admin']);
    if (auth()->user()->hasRole(['super-admin', 'admin'])) {
      return Inertia::render('LeicaComponent/Kee/KeeForm', [
        'countries' => Country::all(),
        'cities' => State::all(),
      ]);
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
    if (auth()->user()->hasRole(['super-admin', 'admin'])) {
      $this->kee_validation($request);
      $kee = Kee::create([
        'title' => $request->title,
        'firstname' => $request->firstname,
        'lastname' => $request->lastname,
        'email' => $request->email,
        'office_name' => $request->office_name,
        'country_id' => $request->country_id,
        'city' => $request->city,
        'specialism' => $request->specialism,
        'h1_link' => $request->h1_link,
        'kee_photo_path'
      ]);

      $kee->user_id = Auth::id();
      $kee->save();
      if ($request->hasFile('avatar')) {
        $kee->addMediaFromRequest('avatar')
          ->toMediaCollection();

        $kee->kee_photo_path = $kee->getFirstMedia()->getUrl();
        $kee->save();
      }
      $added_kee = new KeeResource($kee);
      return Inertia::render('LeicaComponent/Kee/KeeAddEditConfirmation', ['kee' => $added_kee]);
    }
  }


  /**
   * Display the specified resource.
   *
   * @param Kee $kee
   * @return \Inertia\Response
   */
  public function show(KEE $kee): \Inertia\Response
  {
    $country = Country::where('id', $kee->country_id)->get()->toArray();
    $kee = $kee->toArray();
    $kee = array_merge($kee, ['country_name' => $country[0]['name']]);
    // Get all publication belonging to a particular kee
    //$kee = Kee::with('publications')->get());
    return Inertia::render('LeicaComponent/Kee/KeeDetails', ['kee' => $kee

    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return \Inertia\Response
   */
  public function edit(int $id): \Inertia\Response
  {
    if ( auth()->user()->hasRole(['super-admin', 'admin'])) {
      $kee = Kee::find($id);
      if ($kee) {
        return Inertia::render('LeicaComponent/Kee/KeeEditForm', [
          'kee' => $kee,
          'countries' => Country::all(),
          'cities' => State::all(),
          'country' => Country::where('id', $kee->country_id)->get()
        ]);
      }
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
  public function update(Request $request, Kee $kee)
  {
    if ( auth()->user()->hasRole(['super-admin', 'admin'])) {
    $this->kee_validation($request);
    $kee->update($request->all());

    $kee->user_id = Auth::id();
    $kee->save();
    if ($request->hasFile('avatar')) {
      $kee->addMediaFromRequest('avatar')
        ->toMediaCollection();

      $kee->kee_photo_path = $kee->getFirstMedia()->getUrl();
      $kee->save();
    }

    return Inertia::render('LeicaComponent/Kee/KeeAddEditConfirmation');
  }
}

  /**
   * Remove the specified resource from storage.
   *
   * @param Kee $kee
   * @return void
   */
    public function destroy(Kee $kee)
    {
      if (auth()->user()->hasRole(['super-admin', 'admin'])) {
        $kee->delete();
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
        'title' => 'string|min:2|max:20',
        'firstname' => 'string|min:2|max:20',
        'lastname' => 'string|min:2|max:20',
        'email' => 'email',
        'place_of_work' => 'string',
        'country' => 'string',
        'city' => 'string',
        'avatar' => 'file|mimes:jpeg,png|',
      ]);
  }
}
