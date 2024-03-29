<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get('register', 'App\Http\Controllers\Admin\UsersController@create')
    ->name('register.create')
    ->middleware(['guest', 'hasinvitationtoken']);
Route::post('register', 'App\Http\Controllers\Admin\UsersController@store')
    ->name('register.store');

Route::group(['namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth', 'verified']], function () {
    /**
     * API part
     */
    Route::get('/getAvailableGoals/{owner_type}/{id}', 'APIController@getAvailableGoals')->whereIn('owner_type', ['user', 'entity']);

    /**
     * Main part
     */
    Route::get('/', function() {
        return redirect()->route('goals.index');
    })->name('home');

    // Tasks
    Route::delete('tasks/destroy', 'TasksController@massDestroy')->name('tasks.massDestroy');
    Route::apiResource('tasks', 'TasksController');

    // Entities
    Route::delete('entities/destroy', 'EntitiesController@massDestroy')->name('entities.massDestroy');
    Route::apiResource('entities', 'EntitiesController');

    // EntityLevels
    Route::delete('entity_levels/destroy', 'EntityLevelsController@massDestroy')->name('entity_levels.massDestroy');
    Route::apiResource('entity_levels', 'EntityLevelsController');

    // Complete Levels
    Route::delete('complete_levels/destroy', 'CompleteLevelsController@massDestroy')->name('complete_levels.massDestroy');
    Route::apiResource('complete_levels', 'CompleteLevelsController');

    // Goals
    Route::delete('goals/destroy', 'GoalsController@massDestroy')->name('goals.massDestroy');
    Route::apiResource('goals', 'GoalsController');
    Route::post('goals/accept', 'GoalsController@acceptMass')->name('goals.acceptMass');

    // Permissions
    Route::get('/permissions', 'PermissionsController@index')->name('permissions.index');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::apiResource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('invite', 'UsersController@invite')->name('users.invite');
    Route::apiResource('users', 'UsersController');
    Route::post('/users/restore_password', 'UsersController@setPassword')->name('users.setPasswords');
});
