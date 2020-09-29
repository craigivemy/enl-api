<?php

namespace App\Http\Controllers;

use App\PlayedUp;
use App\Season;
use App\Team;
use Illuminate\Http\Request;
use App\Player;
use App\Http\Resources\Player as PlayerResource;
use App\Http\Resources\PlayerCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Throwable;

class PlayerController extends ApiController
{
    /**
     * Display a listing of players.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

            if ($request->input('teamId') && $request->input('seasonId')) {
                $team_id = $request->input('teamId');
                $seasonId = $request->input('seasonId');
                $season = Season::find($seasonId);
                $teamsInSeasonQuery = $season->teams()
                    ->select('teams.id')
                    ->groupBy('teams.id')
                    ->getQuery();

                $teams = Team::whereIn('id', $teamsInSeasonQuery)
                    ->with(['players' => function($query) use($seasonId) {
                        $query->withTrashed()->where('season_id', $seasonId);
                        $query->with(['playedUps' => function($query) use($seasonId) {
                           $query->where('season_id', $seasonId);
                        }]);
                    }])
                    ->get();

                foreach ($teams as $team) {
                    if ($team->id == $team_id) {
                        return $this->respond(new PlayerCollection($team->players));
                    }
                }
            } elseif ($request->input('seasonId') && !$request->input('teamId')) {
                $seasonId = $request->input('seasonId');
                $season = Season::find($seasonId);
                $playersInSeasonQuery = $season->players()
                    ->select('players.id')
                    ->getQuery();

                // todo - should check that seasonId is NOT current before returning withTrashed?
                $players = Player::whereIn('id', $playersInSeasonQuery)
                    ->with(['teams' => function($query) use($seasonId) {
                        $query->withTrashed()->where('season_id', $seasonId);
                    }])
                    ->whereHas('playedUps', function($query) use($seasonId) {
                        $query->where('season_id', $seasonId);
                    })
                    ->with(['playedUps' => function($query) use($seasonId) {
                        $query->where('season_id', $seasonId);
                    }])
                    ->orderBy('surname', 'asc')
                    ->get();

                return $this->respond(new PlayerCollection($players));
            }
            // todo maybe - have one that returns just trashed, then won't be loading all every time - can just load on tab view of 'Restore Players'?
            return $this->respond(new PlayerCollection(Player::withTrashed()->get()));

        } catch (Throwable $t) {
            $meta = ['action' => 'PlayerController@index'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Store a newly created player in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $player = $request->input('player');
            $newPlayer = new Player;
            $newPlayer->forename = $player['forename'];
            $newPlayer->surname = $player['surname'];
            $newPlayer->save();
            DB::insert("INSERT INTO player_season_team (player_id, team_id, season_id) VALUES (?,?,?)",
                [
                    $newPlayer->id,
                    $request->input('teamId'),
                    $request->input('seasonId')
                ]);
            return $this->respondCreated(new PlayerResource($newPlayer));
            /*
             * todo - create fullname / displayname method, check it here and
             * return duplicate entry if it matches - if request contains
             * some sort of flag, allow to create?
             */

        } catch (Throwable $t) {
            $meta = ['action' => 'PlayerController@store'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Display the specified player.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return $this->respond(new PlayerResource(Player::findOrFail($id)));
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Player not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'PlayerController@show'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Update the specified player in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return PlayerResource
     */
    public function update(Request $request, $id)
    {
        try {

            if ($request->query('addPlayedUp')) {
                $seasonId = $request->input('seasonId');
                $player = Player::findOrFail($id);
                $playedUp = new PlayedUp(
                    [
                        'played_up_date' => $request->input('playedUpDate'),
                        'season_id' => $seasonId,
                        'player_id' => $id
                    ]
                );
                $player->playedUps()->save(
                    $playedUp
                );
                $player->save();
                $player->load(['playedUps' => function($q) use ($seasonId) {
                    $q->where('season_id', $seasonId);
                }]);
                return new PlayerResource($player);
                };


            if ($request->query('deletePlayedUp')) {
                $player = Player::findOrFail($id);
                $seasonId = $request->input('seasonId');
                $played_up_id = $request->input('playedUpId');
                $played_up = PlayedUp::find($played_up_id);
                $played_up->delete();
                //$player->playedUps()->detach($played_up_id);
                $player->load(['playedUps' => function($q) use ($seasonId) {
                    $q->where('season_id', $seasonId);
                }]);
                return new PlayerResource($player);
            }



            $player = Player::findOrFail($id);
            $changes = $request->input('player');
            $player->played_up_count = $changes['playedUpCount'];
            // todo - add other fields
            $player->save();
            return $this->respondUpdated($player);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Player not found');
        } catch (Throwable $t) {
            $meta = [
                'action' => 'PlayerController@update',
                'info'   => 'Updating player named: ' . $request->input('forename') . ' ' . $request->input('surname')
            ];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Soft deletes a player
     * (deleted_at value is set to timestamp)
     * @param $id
     * @return ApiController|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function softDelete($id) {
        try {
            Player::destroy($id);
            return $this->respondSoftDeleted();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Player not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'PlayerController@softDelete'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Remove the specified player from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $player = Player::withTrashed()->where('id', $id)->first();
            if (!$player) {
                throw new ModelNotFoundException();
            }
            $player->forceDelete();
            return $this->respondDestroyed();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Player not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'PlayerController@destroy'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }
}
