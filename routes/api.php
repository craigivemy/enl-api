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

Route::apiResources([
    'teams'     => 'TeamController',
    'matches'   => 'MatchController', // /matches needs to be /fixtures and /results instead
    'players'   => 'PlayerController',
    'umpires'   => 'UmpireController',
    'seasons'   => 'SeasonsController',
    'settings'  => 'SettingsController',
    'divisions' => 'DivisionController',
    'clubs'     => 'ClubController'
]);
Route::delete('clubs/{club}/soft', 'ClubController@softDelete');
