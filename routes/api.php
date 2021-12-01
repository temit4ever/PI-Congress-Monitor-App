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



