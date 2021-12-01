<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
      //
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
     * @return \Inertia\Response
     */
    public function show($id)
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole('admin');
      $is_member = auth()->user()->hasRole('member');
      if ($is_admin || $is_super_admin || $is_member) {
        $admin = User::with('roles')->find($id);
        if (empty($admin)) {
          return Inertia::render('LeicaComponent/Error/ItemNotFound');
        }

        return Inertia::render('LeicaComponent/AdminProfile/AdminProfile', ['admin_details' => $admin]);
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
        return Inertia::render('LeicaComponent/User/UserEditForm',
          ['user_details' => $user, 'roles' => $role]);
      }
      else {
        return Inertia::render('LeicaComponent/Error/ErrorPage');
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Inertia\Response
     */
    public function update(Request $request)
    {
      $is_super_admin = auth()->user()->hasRole('super-admin');
      $is_admin = auth()->user()->hasRole( 'admin');
      $is_member = auth()->user()->hasRole('member');
      if (Auth::check() && ($is_admin || $is_super_admin || $is_member)) {
        $this->admin_profile_validation($request);
        $update = User::find($request->id);
        $update->update($request->only([
          'title',
          'firstname',
          'lastname',
          'email',
          'password',
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
        return inertia::render('LeicaComponent/AdminProfile/AdminProfileEditConfirmation');
      }
      else {
        return Inertia::render('LeicaComponent/Error/ErrorPage');
      }

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
   * Common validation for the User controller
   *
   * @param $request
   */
  public function admin_profile_validation($request) {
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
