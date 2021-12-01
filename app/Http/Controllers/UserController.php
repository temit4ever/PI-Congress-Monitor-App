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
use Illuminate\Validation\Rules\Password;
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
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole( 'admin');
      if ($is_admin || $is_super_admin) {
        $term = trim($request->term);
        $user = User::where('id', '!=', auth()->user()->id);
        if ( !$is_super_admin ){
          $user = $user->where('role_id', '>', 1);
        }
        if (!empty($term)) {
            $user = $user->where(function ($query) use ($term) {
              $query
                ->orWhere('lastname','LIKE',  '%' . $term . '%')
                ->orWhere('firstname', 'LIKE', '%' . $term . '%')
                ->orWhere('email', 'LIKE', '%' . $term . '%');
            });
        }
        $user = $user->with('roles')->latest()->paginate(10)->appends($request->all());
        return Inertia::render('LeicaComponent/User/UserList', [
          'user_lists' => $user,
        ]);
      }else {
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
      $is_admin = auth()->user()->hasRole('admin');
      if ($is_admin || $is_super_admin) {
        $role = Role::all()->toArray();
        if ($is_admin) {
          unset($role[0]);
        }
        return Inertia::render('LeicaComponent/User/UserForm',
          ['roles' => $role,
            'authUser' => Auth::user()
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
     * @return \Inertia\Response
     */
    public function store(Request $request): \Inertia\Response
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole( 'admin');
      if ($is_admin || $is_super_admin) {

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
        if ($request->hasFile('avatar')) {
          $user->addMedia($request->avatar)
            ->toMediaCollection('media');
          $user->profile_photo_path = $user->getFirstMedia('media')->getUrl();
          $user->save();
        }
        // Send Notification to new created user
        // This was disabled because, the client didn't want to commit to using direct email contact to created user
       /* if ($user) {
          $user->password = $request->password;
          Notification::send($user, new WelcomeAdmin($user));
        }*/


        return inertia::render('LeicaComponent/User/UserAddEditConfirmation', ['current_user' => $user ]);
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
    public function show($id)
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole('admin');
      $is_member = auth()->user()->hasRole('member');
      if ($is_admin || $is_super_admin || $is_member) {
          $user = User::with('roles')->find($id);
          if (empty($user)) {
            return Inertia::render('LeicaComponent/Error/ItemNotFound');
          }

          return Inertia::render('LeicaComponent/User/UserDetails', ['user_details' => $user]);
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
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole( 'admin');
      $is_member = auth()->user()->hasRole('member');
      if ($is_admin || $is_super_admin || $is_member) {
        $role = Role::all()->toArray();
        if ($is_admin) {
          unset($role[0]);
        }
        $user = User::with('roles')->find($id);
        //dd($user);
        return Inertia::render('LeicaComponent/User/UserEditForm',
          ['user_details' => $user, 'roles' => $role]);
      }
      return Inertia::render('LeicaComponent/Error/ItemNotFound');
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
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole( 'admin');
      $is_member = auth()->user()->hasRole( 'member');
      if (Auth::check() && ($is_admin || $is_super_admin || $is_member)) {
        $this->user_validation($request);
          $update = User::find($request->id);
          $updated_id = $update->id;
          $update->update($request->only([
            'title',
            'firstname',
            'lastname',
            'email',
            'password',
            'role_id'
          ]));
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

          if ($request->hasFile('avatar')) {
            $update->clearMediaCollection('media');
            $update->addMedia($request->avatar)->toMediaCollection('media');
            $update->profile_photo_path = $update->getFirstMedia('media')->getUrl();
            $update->save();
          }
          return inertia::render('LeicaComponent/User/UserAddEditConfirmation', ['updated_id' => $updated_id]);
      }
      else {
        return Inertia::render('LeicaComponent/Error/ErrorPage');
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
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole( 'admin');
      if ($is_admin || $is_super_admin) {
      $user = User::find($id);
      if ($user) {
        $user->delete();
        return Redirect::route('user.index');
      }
      }
      else {
        return Inertia::render('LeicaComponent/Error/ErrorPage');
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
          'firstname' => 'required|min:2|max:20',
          'lastname' => 'required|min:2|max:20',
          'email' => 'required|email:rfc,filter,dns',
          'role_id' => 'required',
          'password' => [
            'required',
            Password::min(6)->letters()->numbers()->symbols()
          ],
          'confirm_password' => [
            'required',
            'same:password',
            Password::min(6)->letters()->numbers()->symbols()
          ]

        ]
      );
    }
}
