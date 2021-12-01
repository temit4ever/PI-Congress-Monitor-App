<?php

use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\CompletedEngagementController;
use App\Http\Controllers\EngagementController;
use App\Http\Controllers\GetCityController;
use App\Http\Controllers\KeeController;
use App\Http\Controllers\KeeEngagementHistoryController;
use App\Http\Controllers\KeeRankHistoryController;
use App\Http\Controllers\KeeUploadController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use App\Models\Engagement;
use App\Models\Kee;
use App\Models\Rank;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use WisdomDiala\Countrypkg\Models\Country;

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
  return Inertia::render('Auth/Login', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
});

Route::middleware('auth')->get('/dashboard', function () {

  // Get all the engagement in current quarter
  $quarterly_engagement = Engagement::where(DB::raw('QUARTER(calendar_date)'), Carbon::now()->quarter)->get();

  // Get all the engagement in current year
  $yearly_engagement = Engagement::where(DB::raw('YEAR(calendar_date)'), Carbon::now()->year)->get();

  // Get all the upcoming engagement in current quarter
  $upcoming_engagement = Engagement::whereDate('calendar_date', '>=', Carbon::now())->orderBy('calendar_date', 'ASC')
    ->paginate(10);

  // Get all the planned engagement in current quarter
  $plan_engagement_quarter = count(Engagement::whereDate('calendar_date', '>=', Carbon::now())
    ->where(DB::raw('QUARTER(calendar_date)'), Carbon::now()->quarter)->get());

  //dd($plan_engagement_quarter);
  //$quarter_name = '';
  switch (Carbon::now()->quarter) {
    case '1' :
      $quarter_name = 'Q1';
      break;
    case '2' :
      $quarter_name = 'Q2';
      break;
    case '3' :
      $quarter_name = 'Q3';
      break;
    case '4' :
      $quarter_name = 'Q4';
      break;
  }
  $engagement_id_yearly = $yearly_engagement->pluck('id');
  $engagement_id_quarterly = $quarterly_engagement->pluck('id')->unique();

  // Get all the rank of kee that attend specific engagement in current year
  $yearly_rank = Rank::whereIn('engagement_id', $engagement_id_yearly)->where('attendance', '=', 'Yes')
    ->where('is_evaluated', '=', '1')
    ->where(DB::raw('YEAR(created_at)'), Carbon::now()->year)->get();
  $yearly_attendance = count( $yearly_rank->pluck('engagement_id')->unique());

  // Get all the rank of kee that attend specific engagement in current quarter
  $attended_engagement_quarterly = Rank::whereIn('engagement_id', $engagement_id_quarterly)->where('attendance', '=', 'Yes')
    ->where('is_evaluated', '=', '1')->where(DB::raw('YEAR(created_at)'), Carbon::now()->year)->get();
  $attended_engagement_quarterly = count( $attended_engagement_quarterly->pluck('engagement_id')->unique());
  $yearly_engagement = count($yearly_engagement);

  $yearly_engagement_percentage = '';
  if ($yearly_attendance != 0 && $yearly_engagement != 0) {
    $yearly_engagement_percentage = round(($yearly_attendance / $yearly_engagement * 100), 0);
  }

  $quarter_engagement_percentage = '';
  $quarterly_engagement = count($quarterly_engagement);
  if ($quarterly_engagement != 0 && $attended_engagement_quarterly != 0) {
    $quarter_engagement_percentage = round(($attended_engagement_quarterly / $quarterly_engagement * 100), 0);
  }

  $rank = KEE::query()
    ->join('ranks', function ($join) {
      $join->on('kees.id', '=', 'ranks.kee_id')
        ->on('ranks.id', '=', DB::raw("(SELECT MAX(id) FROM ranks WHERE ranks.kee_id = kees.id AND ranks.attendance != 'No' AND ranks.is_evaluated = 1
        AND ranks.deleted_at is null)"));
    })
    ->select('kees.*',
      'ranks.id AS eid',
      'ranks.rank',
      'ranks.commitment_status',
      'ranks.understanding_data_status',
      'ranks.performance_status'
    )
    ->orderBy('ranks.created_at', 'DESC')
    ->paginate(10);
  $country_details = [];

  foreach ($upcoming_engagement->toArray()['data'] as $data) {
    $id = $data['country_id'];
    if (!empty($id)) {
      $country = Country::find($id);
      if (empty($country)) {
        return Inertia::render('LeicaComponent/Error/ItemNotFound');
      }
      $country_details[$id] = $country['short_name'];
      $engagement_id[] = $data['id'];
    }
  }
  // Get the list of all grade 'A' Ranks in a year based on specific engagement.
   $yearly_grade_a_rank = Rank::whereIn('engagement_id', $engagement_id_yearly)->where('attendance', '=', 'Yes')
    ->where('is_evaluated', '=', '1')->where('rank', 'A')
    ->where(DB::raw('YEAR(created_at)'), Carbon::now()->year)->get();
  $yearly_grade_a_rank = count($yearly_grade_a_rank);

  // Get the list of all Ranks engagement in the whole year
  $yearly_rank_total = Rank::where('attendance', '=', 'Yes')
    ->where('is_evaluated', '=', '1')->where('rank', '!=', 'None')
    ->where(DB::raw('YEAR(created_at)'), Carbon::now()->year)->get();
  $yearly_rank_total = count($yearly_rank_total);

  $yearly_grade_percentage = '';
  if ($yearly_grade_a_rank != 0 && $yearly_rank_total != 0) {
    $yearly_grade_percentage = round(($yearly_grade_a_rank / $yearly_rank_total * 100), 0);
  }

  if (empty($rank)) {
    return Inertia::render('LeicaComponent/Error/ErrorPage');
  }
  return Inertia::render('Dashboard', [
    'AuthUser' => Auth::user(),
    'upcoming_engagement' => $upcoming_engagement,
    'country' => $country_details,
    'details' => $rank,
    'plan_engagement_quarter' => $plan_engagement_quarter,
    'attended_engagement_quarterly' => $attended_engagement_quarterly,
    'total_per_quarter' => $quarterly_engagement,
    'yearly_attendance' => $yearly_attendance,
    'grade' => $yearly_grade_a_rank,
    'total_rank' => $yearly_rank_total,
    'grade_a_rank' => $yearly_grade_a_rank,
    'year' => Carbon::now()->format('Y'),
    'yearly_engagement_percentage' => $yearly_engagement_percentage,
    'yearly_engagement' => $yearly_engagement,
    'quarter_name' => $quarter_name,
    'quarter_engagement_percentage' => $quarter_engagement_percentage,
    'yearly_grade_percentage' => $yearly_grade_percentage,
  ]);
})->name('dashboard');


Route::middleware('auth')->prefix('dashboard')->group(function () {
  /**
   * Endpoints for managing user CRUD
   */
  //Route::get('/manage/user', [UserController::class, 'index'])->name('user.index');
  Route::resource('/manage/user', UserController::class)->except('destroy', 'update');
  Route::get('/manage/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
  Route::post('/manage/user/update', [UserController::class, 'update'])->name('user.update');

  /**
   * Endpoints for managing KEE CRUD
   */
  Route::resource('/manage/kee', KeeController::class, [
    'names' => [
      'index' => 'manage_kee.index',
      'edit' => 'manage_kee.edit',
      'create' => 'manage_kee.create',
      'store' => 'manage_kee.store'
    ]
  ])->except('delete', 'update', 'show');
  Route::get('/manage/kee/delete/{id}', [KeeController::class, 'delete'])->name('manage_kee.delete');
  Route::post('/manage/kee/update', [KeeController::class, 'update'])->name('manage_kee.update');
  Route::get('/manage/kee/{id}', [KeeController::class, 'show'])->name('manage_kee.show');

  Route::resource('/kee', KeeController::class)->except('destroy', 'update');
  Route::get('kee/{id}', [KeeController::class, 'show'])->name('kee.shows');
  Route::get('/kee/delete/{id}', [KeeController::class, 'delete'])->name('kee.delete');
  Route::post('/kee/update', [KeeController::class, 'update'])->name('kee.update');

  /**
   * Endpoints for managing Engagement CRUD
   */
  Route::resource('/manage/engagement', EngagementController::class, [
    'names' => [
      'index' => 'manage_engagement.index',
      'show' => 'manage_engagement.show',
      'edit' => 'manage_engagement.edit',
      'update' => 'manage_engagement.update',
      'store' => 'manage_engagement.store',
      'create' => 'manage_engagement.create'
    ]
  ])->except('delete', 'update');
  Route::get('/manage/engagement/delete/{id}', [EngagementController::class, 'delete'])->name('manage_engagement.delete');
  Route::post('/manage/engagement/update', [EngagementController::class, 'update'])->name('manage_engagement.update');
  //Route::post('/manage/engagement/create', [EngagementController::class, 'update'])->name('manage_engagement.create');


  Route::resource('/engagement', EngagementController::class)->except('destroy', 'update');
  Route::get('/engagement/delete/{id}', [EngagementController::class, 'delete'])->name('engagement.delete');
  Route::post('/engagement/update', [EngagementController::class, 'update'])->name('engagement.update');

  /**
   * Endpoints for managing Evaluation CRUD
   */
  Route::resource('/manage/rank', RankController::class)->only(['index', 'store', 'show']);
  Route::get('/manage/rank/show/{id}', [RankController::class, 'show'])->name('manage_rank.show');
  Route::get('/manage/rank/delete/{id}', [RankController::class, 'delete'])->name('rank.delete');
  Route::post('/rank/update', [RankController::class, 'update'])->name('rank.update');
  Route::get('/manage/rank/create/{id}', [RankController::class, 'create'])->name('manage_rank.create');

  /**
   * Endpoints for managing Calendar which filter by month and perform search
   */
  Route::resource('/calendar', CalendarController::class)
    ->only(['index', 'store']);
  /**
   * Endpoints for schedule
   */
  Route::resource('/manage/schedule', ScheduleController::class, [
    'names' => [
      'index' => 'manage_schedule.index',
      'show' => 'manage_schedule.show',
      'edit' => 'manage_schedule.edit',
      'store' => 'manage_schedule.store',
      'create' => 'manage_schedule.create',
    ]
  ])->except('delete', 'update',);
  //Route::get('/manage/schedule/create/{id}', [ScheduleController::class, 'create'])->name('manage_schedule.create');
  //Route::get('schedule/create/{id}', [ScheduleController::class, 'create'])->name('manage_schedule.create');
  Route::get('schedule/create', [ScheduleController::class, 'create'])->name('schedule.create');
  Route::post('schedule/store', [ScheduleController::class, 'store'])->name('schedule.store');



  /**
   * Endpoints for admin profile page
   */
  Route::resource('/manage/admin/profiles', AdminProfileController::class)->except(['update']);
  Route::post('/manage/profiles/update', [AdminProfileController::class, 'update'])->name('profiles.update');



  /**
   * Endpoints for managing permissions
   */
  Route::resource('/manage/permission', PermissionController::class)
    ->only(['index']);

  /**
   * Endpoints for managing roles
   */
  Route::resource('/manage/role', RoleController::class)
    ->only(['index']);

  /**
   * Endpoints for managing Publication CRUD
   */
  Route::resource('/publication', PublicationController::class);


  //Route::get('/manage/completed', [CompletedEngagementController::class, 'index'])->name(['manage_completed.index']);
  Route::resource('/manage/completed', CompletedEngagementController::class, [
    'names' => [
      'index' => 'manage_completed.index',
      'show' => 'manage_completed.show',
    ]
  ])->except('delete', 'update', 'edit',);

  Route::resource('/getcity', GetCityController::class)->only(['index']);

  Route::resource('/manage', ManageController::class)->only(['index']);

  Route::get('/manage/history/{id}', [KeeRankHistoryController::class, 'index'])
    ->name('manage_history.index');
  Route::get('/history/{id}', [KeeRankHistoryController::class, 'index'])
    ->name('history.index');
  Route::resource('/manage/keeupload', KeeUploadController::class)->only(['create', 'store']);


  Route::get('/classification', [ClassificationController::class, 'index'])->name('classification.index');
  Route::get('/manage/engagement/ehistory/{id}', [KeeEngagementHistoryController::class, 'index'])->name('manage_ehistory.index');
  Route::get('/engagement/ehistory/{id}', [KeeEngagementHistoryController::class, 'index'])->name('ehistory.index');

  //Route::resource('/manage/admin/profile', AdminProfileController::class);

  Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

});
