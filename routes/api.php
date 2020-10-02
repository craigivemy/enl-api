<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:api'], function() {
    Route::apiResources([
        'teams'     => 'TeamController',
        'matches'   => 'MatchController',
        'players'   => 'PlayerController',
        'umpires'   => 'UmpireController',
        'seasons'   => 'SeasonController',
        'settings'  => 'SettingController',
        'divisions' => 'DivisionController',
        'statistics'    => 'StatisticController',
        'clubs'     => 'ClubController',
        'divisions-tables' => 'DivisionTablesController'
    ]);
    Route::delete('clubs/{club}/soft', 'ClubController@softDelete');
    Route::delete('umpires/{umpire}/soft', 'UmpireController@softDelete');
    Route::delete('batch/teams', 'TeamController@batchDelete');
    Route::post('batchRestore/teams', 'TeamController@batchRestore');
});

