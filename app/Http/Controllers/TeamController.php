<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlayerCollection;
use App\Player;
use App\Season;
use Illuminate\Http\Request;
use App\Team;
use App\Http\Resources\Team as TeamResource;
use App\Http\Resources\TeamCollection;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class TeamController extends ApiController
{
    /**
     * Display a listing of teams.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $seasonId = $request->input('seasonId');
            $season = Season::find($seasonId);

            if ($request->input('withPlayers')) {
                $teamsInSeasonQuery = $season->teams()
                    ->select('teams.id')
                    ->getQuery();
                $teams = Team::withTrashed()->whereIn('id', $teamsInSeasonQuery)
                    ->with(['players' => function($query) use($seasonId) {
                        $query->withTrashed();
                        $query->where('season_id', $seasonId);
                        $query->orderBy('surname', 'asc');
                    }])
                    ->with(['seasons' => function($query) use($seasonId) {
                        $query->where('season_id', '=', $seasonId);
                    }])
                    ->orderBy('name', 'asc')
                    ->get();

                return $this->respond(new TeamCollection($teams));
            }


            return $this->respond(new TeamCollection(Team::withTrashed()->with(['seasons' => function($query) use($seasonId) {
                $query->where('season_id', '=', $seasonId);
            }])->orderBy('name')->get()));


        } catch (Throwable $t) {
            $meta = ['action' => 'TeamController@index'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Store a newly created team in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $team = $request->input('team');
            $newTeam = new Team;
            $newTeam->name = $team['name'];
            $newTeam->narrative = $team['narrative'];
            $newTeam->primary_colour = $team['primaryColour'];
            $newTeam->secondary_colour = $team['secondaryColour'];
            $newTeam->tertiary_colour = $team['tertiaryColour'];
            $newTeam->save();
            return $this->respondCreated($newTeam);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                $message = 'A team with that name already exists.';
                $meta = [
                    'action' => 'TeamController@store',
                    'info'   => 'Creating team named: ' . $request->input('name')
                ];
                $this->logger->log('info', $e->getMessage(), ['exception' => $e, 'meta' => $meta]);
                return $this->respondDuplicateEntry($message);
            }
        } catch (Throwable $t) {
            $meta = ['action' => 'TeamController@store'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Display the specified team.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            if ($request->query('pointAdjustments')) {
                $season_id = $request->query('seasonId');
                $rows = DB::table('team_point_adjustments')->where(['team_id' => $id, 'season_id' => $season_id])->get();
                return $this->respond([
                    "data" => $rows
                ]);
            }

            return $this->respond(new TeamResource(Team::findOrFail($id)));
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Team not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'TeamController@show'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Update the specified team in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // todo - https://stackoverflow.com/questions/32508850/laravel-5-updating-multiple-records
    // add another method for batch update - actually also for batch delete
    public function update(Request $request, $id)
    {
        try {

            if ($request->input('teamPointAdjustments')) {
                $team = Team::findOrFail($id);
                $season_id = $request->input('seasonId');
                $adjustments = $request->input('adjustments');

                //return $adjustments["deductions"];
// use the ids
                DB::delete("DELETE from team_point_adjustments where team_id=" . $id . " AND season_id=" . $season_id);

                foreach ($adjustments['deductions'] as $adjustment) {
                    DB::table('team_point_adjustments')->insert([
                        'team_id' => $id,
                        'point_adjustment' => $adjustment['deduction'], // test

                        'reason' => $adjustment['reason'],
                        'reason_date' => $adjustment['reasonDate'],
                        'season_id' => $season_id
                    ]);
                }
                return 1;
            }

            // from season
            if ($request->input('deletePlayers')) {
                $season_id = $request->input('seasonId');
                $ids = $request->input('ids');
                foreach ($ids as $id) {
                    DB::table('player_season_team')->where('season_id', $season_id)->where('player_id', $id)->delete();
                }
                return 1;

            }

            $team = Team::findOrFail($id);
            $changes = $request->input('changes');
            $team->fill($changes);
            $team->save();
            return $this->respondUpdated($team);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                $message = 'A team with that name already exists.';
                $meta = [
                    'action' => 'TeamController@update',
                    'info'   => 'Updating team named: ' . $request->input('name')
                ];
                $this->logger->log('info', $e->getMessage(), ['exception' => $e, 'meta' => $meta]);
                return $this->respondDuplicateEntry($message);
            }
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Team not found');
        } catch (Throwable $t) {
            $meta = [
                'action' => 'TeamController@update',
                'info'   => 'Updating team named: ' . $request->input('name')
            ];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    public function batchDelete(Request $request) {
        try {
            Team::destroy($request->ids);
            return $this->respondSoftDeleted();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Team not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'TeamController@batchDelete'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    public function batchRestore(Request $request) {
        try {
            //Log::debug('', $request->input('ids'));
            Team::onlyTrashed()->whereIn('id', $request->input('ids'))->restore();
            //Team::restore($request->ids);
            return $this->respond([]);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Team not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'TeamController@batchRestore'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Soft deletes a team
     * (deleted_at column is set to timestamp)
     *
     * @param $id
     * @return ApiController|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function softDelete($id) {
        try {
            Team::destroy($id);
            return $this->respondSoftDeleted();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Team not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'TeamController@softDelete'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Remove the specified team from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $team = Team::withTrashed()->where('id', $id)->first();
            if (!$team) {
                throw new ModelNotFoundException();
            }
            $team->forceDelete();
            return $this->respondDestroyed();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Team not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'TeamController@destroy'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }
}
