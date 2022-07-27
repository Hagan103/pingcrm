<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BodyController;
use App\Http\Controllers\BodyDiffController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RunController;
use App\Http\Controllers\scheduleController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\WorkoutEventController;
use Illuminate\Support\Facades\Route;

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

// Auth

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');



// workouts
Route::get('workouts', [WorkoutController::class, 'index'])
    ->name('workouts')
    ->middleware('auth');


// schedules
Route::get('schedules/{schedule}/edit', [ScheduleController::class, 'edit'])
    ->name('schedules')
    ->middleware('auth');

Route::get('schedules', [ScheduleController::class, 'index'])
    ->name('schedules')
    ->middleware('auth');

Route::put('schedules/{schedule}', [ScheduleController::class, 'update'])
    ->name('schedules.update')
    ->middleware('auth');



// body difdi
Route::get('bodydiff/{schedule}', [BodyDiffController::class, 'index'])
    ->name('bodydjff.index')
    ->middleware('auth');



// workout events
Route::post('workout-events', [WorkoutEventController::class, 'store'])
    ->name('workout-events.store')
    ->middleware('auth');

Route::delete('workout-events/{workoutEvent}', [WorkoutEventController::class, 'destroy'])
    ->name('workout-events.destroy')
    ->middleware('auth');


// runs
Route::get('runs', [RunController::class, 'index'])
    ->name('runs')
    ->middleware('auth');

Route::get('runs/create', [RunController::class, 'create'])
    ->name('runs.create')
    ->middleware('auth');




Route::post('runs', [RunController::class, 'store'])
    ->name('runs.store')
    ->middleware('auth');

Route::get('runs/{body}/edit', [RunController::class, 'edit'])
    ->name('runs.edit')
    ->middleware('auth');

Route::put('runs/{body}', [RunController::class, 'update'])
    ->name('runs.update')
    ->middleware('auth');

Route::delete('runs/{body}', [RunController::class, 'destroy'])
    ->name('runs.destroy')
    ->middleware('auth');




// bodies

Route::get('bodies', [BodyController::class, 'index'])
    ->name('bodies')
    ->middleware('auth');

Route::get('bodies/create', [BodyController::class, 'create'])
    ->name('bodies.create')
    ->middleware('auth');

Route::get('bodies/createbody', [BodyController::class, 'createBody'])
    ->name('bodies.createBody')
    ->middleware('auth');

Route::post('bodies', [BodyController::class, 'store'])
    ->name('bodies.store')
    ->middleware('auth');

Route::get('bodies/{body}/edit', [BodyController::class, 'edit'])
    ->name('bodies.edit')
    ->middleware('auth');

Route::put('bodies/{body}', [BodyController::class, 'update'])
    ->name('bodies.update')
    ->middleware('auth');

Route::delete('bodies/{body}', [BodyController::class, 'destroy'])
    ->name('bodies.destroy')
    ->middleware('auth');


// Organizations

Route::get('organizations', [OrganizationsController::class, 'index'])
    ->name('organizations')
    ->middleware('auth');

Route::get('organizations/create', [OrganizationsController::class, 'create'])
    ->name('organizations.create')
    ->middleware('auth');

Route::post('organizations', [OrganizationsController::class, 'store'])
    ->name('organizations.store')
    ->middleware('auth');

Route::get('organizations/{organization}/edit', [OrganizationsController::class, 'edit'])
    ->name('organizations.edit')
    ->middleware('auth');

Route::put('organizations/{organization}', [OrganizationsController::class, 'update'])
    ->name('organizations.update')
    ->middleware('auth');

Route::delete('organizations/{organization}', [OrganizationsController::class, 'destroy'])
    ->name('organizations.destroy')
    ->middleware('auth');

Route::put('organizations/{organization}/restore', [OrganizationsController::class, 'restore'])
    ->name('organizations.restore')
    ->middleware('auth');

// Contacts

Route::get('contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('auth');

Route::get('contacts/create', [ContactsController::class, 'create'])
    ->name('contacts.create')
    ->middleware('auth');

Route::post('contacts', [ContactsController::class, 'store'])
    ->name('contacts.store')
    ->middleware('auth');

Route::get('contacts/{contact}/edit', [ContactsController::class, 'edit'])
    ->name('contacts.edit')
    ->middleware('auth');

Route::put('contacts/{contact}', [ContactsController::class, 'update'])
    ->name('contacts.update')
    ->middleware('auth');

Route::delete('contacts/{contact}', [ContactsController::class, 'destroy'])
    ->name('contacts.destroy')
    ->middleware('auth');

Route::put('contacts/{contact}/restore', [ContactsController::class, 'restore'])
    ->name('contacts.restore')
    ->middleware('auth');

// Reports

Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');
