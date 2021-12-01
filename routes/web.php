<?php

use App\Http\Controllers\EngagementController;
use App\Http\Controllers\GetCityController;
use App\Http\Controllers\KeeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
});

Route::middleware('auth')->get('/dashboard', function () {
  return Inertia::render('Dashboard', ['AuthUser' => auth()->user()]);
})->name('dashboard');

Route::middleware('auth')->prefix('dashboard')->group(function () {
  /**
   * Endpoints for managing user CRUD
   */
  Route::resource('/user', UserController::class)->except('destroy', 'update');
  Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
  Route::post('/user/update', [UserController::class, 'update'])->name('user.update');

  /**
   * Endpoints for managing KEE CRUD
   */
  Route::resource('/kee', KeeController::class)->except('destroy');
  Route::get('/kee/delete/{id}', [KeeController::class, 'delete'])->name('kee.delete');

  /**
   * Endpoints for managing Engagement CRUD
   */
  Route::resource('/engagement', EngagementController::class)->except('destroy');
  Route::get('/engagement/delete/{id}', [EngagementController::class, 'delete'])->name('engagement.delete');


  /**
   * Endpoints for managing permissions
   */
  Route::resource('/permission', PermissionController::class)
    ->only(['index']);

  /**
   * Endpoints for managing roles
   */
  Route::resource('/role', RoleController::class)
    ->only(['index']);

  /**
   * Endpoints for managing Publication CRUD
   */
  Route::resource('/publication', PublicationController::class);


  Route::resource('/getcity', GetCityController::class)->only(['index']);


});
