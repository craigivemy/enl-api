<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Logging\CustomLogger;
use App\Player;
use Illuminate\Http\Request;
use App\Season;
use App\Http\Resources\Season as SeasonResource;
use App\Http\Resources\SeasonCollection;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;
use Throwable;

class SeasonController extends ApiController
{
    /**
     * Display a listing of seasons.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            return $this->respond(new SeasonCollection(Season::all()));
        } catch (Throwable $t) {
            $meta = ['action' => 'SeasonController@index'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Store a newly created season in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // todo - only 1 should be able to be pending? or on front end don't allow add, juist show pending one they can edit?
            $current_season = Season::where('current', 1)->first();
            $season = new Season();
            $season_request = $request->input('season');
            $divisions_teams_request = $request->input('divisionsTeams');
            $settings_request = $request->input('settings');
            $basic_details_request = $request->input('basicDetails');
            $season->name = $season_request['name'];
            $season->rounds = $season_request['rounds'];
            $season->current = $season_request['current'];
            $season->start_date = $season_request['startDate'];
            $season->saveOrFail();

            $newTeams = [];
            foreach ($divisions_teams_request as $key => $row) {
                foreach ($row as $sub => $val) {
                    $newTeams[] = $val['id'];
                    DB::table('division_season_team')->insert(
                        [
                            'season_id' => $season->id,
                            'division_id' => $key,
                            'team_id'   => $val['id']
                        ]
                    );
                }
            }
            foreach ($newTeams as $team_id) {
                DB::statement("INSERT INTO player_season_team (season_id, player_id, team_id)
                SELECT " . $season->id . ", player_id, team_id FROM player_season_team WHERE team_id = " . $team_id . " 
                AND season_id = " . $current_season->id);
            }

            foreach ($settings_request as $key => $value) {
                DB::table('settings')->insert(
                    [
                        'name' => $key,
                        'setting_value' => $value,
                        'season_id'     => $season->id
                    ]
                );
            }
            foreach ($basic_details_request as $key => $value) {
                DB::table('settings')->insert(
                    [
                        'name' => $key,
                        'setting_value' => $value,
                        'season_id'     => $season->id
                    ]
                );
            }

            // todo -at the moment, always will be, until save / pending is in place
            if ($season->current === 1) {
               Season::where('current', 1)
                   ->where('id', '!=', $season->id)
                   ->update(['current' => 0]);
            }
            return $this->respondCreated($season);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                $message = 'A season with that name already exists.';
                $meta = [
                    'action' => 'SeasonController@store',
                    'info'   => 'Creating season named: ' . $request->input('name')
                ];
                $this->logger->log('info', $e->getMessage(), ['exception' => $e, 'meta' => $meta]);
                return $this->respondDuplicateEntry($message);
            }
        } catch (Throwable $t) {
            $meta = ['action' => 'SeasonController@store'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Display the specified season.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return $this->respond(new SeasonResource(Season::findOrFail($id)));
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Season not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'SeasonController@show'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Update the specified season in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $season = Season::findOrFail($id);
            $season->fill($request->except('id'));
            $season->save();
            return $this->respondUpdated($season);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Season not found');
        } catch (Throwable $t) {
            $meta = [
                'action' => 'SeasonController@update',
                'info'   => 'Updating season named: ' . $request->input('name')
            ];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Soft deletes a season
     * (deleted_at value is set to timestamp)
     *
     * @param $id
     * @return ApiController|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function softDelete($id) {
        try {
            Season::destroy($id);
            return $this->respondSoftDeleted();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Season not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'SeasonController@softDelete'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Remove the specified season from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $season = Season::withTrashed()->where('id', $id)->first();
            if (!$season) {
                throw new ModelNotFoundException();
            }
            $season->forceDelete();
            return $this->respondDestroyed();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Season not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'SeasonController@destroy'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }
}
