<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Notifications\WelcomeAdmin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
      $id = Auth::id();

      $term = trim($request->term);
      if (!empty($request->term)) {
        $user = User::where('firstname', 'LIKE', '%' . $term)
          ->orWhere('lastname', 'LIKE', '%' . $term .'%')
          ->orWhere('email', 'LIKE', '%' . $term . '%')
          ->where('id', '=', $id)
          ->paginate();

        $user = UserResource::collection($user->sortByDesc('created_at'));
      }
      else {
        $user = UserResource::collection(User::whereNotIn('id', [$id])->get()->sortByDesc('created_at'));
      }
      return Inertia::render('LeicaComponent/User/UserList', [
        'user_lists' => $user,
      ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
      //dd(Auth::user()->role_id);
      $current_user = Auth::user();
     // dd( $current_user->role_id);
      $roles = Role::all();
      //$role_new = [];
      foreach ($roles as $role){
        //dd($role->name );
       if ($current_user->role_id == $role->id && $role->name == 'Admin') {
         $role_new[2] = 'Admin';
         $role_new[3] = 'Member';
         //dd($role_new);
       }
       //d($role_new);
      }
      $role_new = Role::all();
        return Inertia::render('LeicaComponent/User/UserForm',
        ['roles' => $role_new,
          'authUser' => Auth::user()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function store(Request $request): \Inertia\Response
    {
      $user = null;
      if (auth()->user()->hasRole(['super-admin', 'admin'])) {

        $this->user_validation($request);

        $user = User::create([
          'title' => $request->title,
          'firstname' => $request->firstname,
          'lastname' => $request->lastname,
          'email' => $request->email,
          'password' => bcrypt($request->password),
          'role_id' => $request->role_id,
        ]);

        $user->save();

        $role_id = Role::find($request->role_id);
        if (isset($role_id)) {
          $user->assignRole($role_id);
        }
        switch ($role_id->id) {
          case 1:
            $user->status = 'super-admin';
            break;
          case 2:
            $user->status = 'admin';
            break;
          default:
            $user->status = 'member';
        }
        $user->save();
        //dd($request);
        if ($request->hasFile('avatar')) {
          $user->addMedia($request->avatar)
            ->toMediaCollection('media');
          $user->profile_photo_path = $user->getFirstMedia('media')->getUrl();
          $user->save();
        }
      }

      // Send Notification to new created user
      if ($user) {
        $user->password = $request->password;
        Notification::send($user, new WelcomeAdmin($user));

      }
      return inertia::render('LeicaComponent/User/UserAddEditConfirmation');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
      if (auth()->user()->hasRole(['super-admin', 'admin'])) {
        $user = User::with('roles')->find($id);
        return Inertia::render('LeicaComponent/User/UserDetails', ['user' => $user]);
      }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
      if (auth()->user()->hasRole(['super-admin', 'admin'])) {
        $user = User::with('roles')->find($id);
        return Inertia::render('LeicaComponent/User/UserEditForm',
          ['user_details' => $user, 'roles' => Role::all()]);
      }
    }
  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param User $user
   * @return \Inertia\Response
   */
    public function update(Request $request)
    {

      try {
        $update = User::find($request->id);
        $update->update($request->all());
        $update->password = bcrypt($request->password);
        $role_id = Role::find($request->role_id);
        if (isset($role_id)) {
          $update->assignRole($role_id);
        }
        switch ($role_id->id) {
          case 1:
            $update->status = 'super-admin';
            break;
          case 2:
            $update->status = 'admin';
            break;
          default:
            $update->status = 'member';
        }
        $update->save();

        // dd($request->avatar);
        if ($request->hasFile('avatar')) {
          $update->clearMediaCollection('media');
          $update->addMedia($request->avatar)->toMediaCollection('media');
          $update->profile_photo_path = $update->getFirstMedia('media')->getUrl();
          $update->save();
        }

        return inertia::render('LeicaComponent/User/UserAddEditConfirmation');
      } catch (\Exception $exception) {
        return Inertia::render('LeicaComponent/Exception/GeneralException');
      }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|RedirectResponse|\Illuminate\Routing\Redirector|\Inertia\Response
     */
    public function delete($id)
    {
      if (auth()->user()->hasRole(['super-admin', 'admin'])) {
      $user = User::find($id);
      if ($user) {
        $user->delete();
        return Redirect::route('user.index');
      }
      }
    }

  /**
   * Common validation for the User controller
   *
   * @param $request
   */
  public function user_validation($request) {
      $request->validate(
        [
          'title' => 'filled|string|min:2|max:20',
          'firstname' => 'filled|string|min:2|max:20',
          'lastname' => 'filled|string|min:2|max:20',
          'email' => 'filled|email',
          'role_id' => 'filled',
          'password' => [
            'filled',
            'string',],
        ]
      );
    }
}
