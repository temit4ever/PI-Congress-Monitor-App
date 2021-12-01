<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CompletedController;
use App\Http\Controllers\CompletedEngagementController;
use App\Http\Controllers\EngagementController;
use App\Http\Controllers\EngagementSearchSortController;
use App\Http\Controllers\KeeController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\RankController;
use \App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UpcomingEngagementController;
use App\Http\Controllers\SearchSortEngagementController;
use App\Http\Controllers\SearchSortkeeController;
use App\Http\Controllers\SearchSortUserController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Once we start getting data from the form, we have to uncomment this line
/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/



/**
 * Add authentication to all endpoints created in the group
 */
// Once we start getting data from the form, we have to uncomment this line and delete the next one
//Route::middleware(['auth.sanctum', 'verified'])->group(function () {

Route::prefix('dashboard')->group(function () {
  Route::get('dashboard', []);

  /**
   * Endpoints for managing KEE CRUD
   */
  Route::resource('/kee', KeeController::class);

  /**
   * Endpoints for managing Engagement CRUD
   */
  Route::resource('/engagement', EngagementController::class);

  /**
   * Endpoints for managing Evaluation CRUD
   */
  Route::resource('/rank', RankController::class);

  /**
   * Endpoints for managing Publication CRUD
   */
  Route::resource('/publication', PublicationController::class);

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
   * Endpoints for completed Engagement roles
   */
  Route::resource('/completedengagement', CompletedEngagementController::class);

  /**
   * Endpoints for managing Upcoming Engagement List
   */
  /*Route::resource('/upcomingengagement', UpcomingEngagementController::class)
    ->only(['index', 'store']);*/

  /**
   * Endpoints for managing user CRUD
   */
  Route::resource('/user', UserController::class);

  /**
   * Endpoints for managing Calendar which filter by month and perform search
   */
  Route::resource('/engagement/calendar', CalendarController::class)
    ->only(['index', 'store']);
});

