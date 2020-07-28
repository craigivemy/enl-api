<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;
use App\Player;
use App\Http\Resources\Player as PlayerResource;
use App\Http\Resources\PlayerCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

            if ($team_id = $request->input('teamId')) {
                return $this->respond(new PlayerCollection(Player::where('team_id', '=', $team_id)->get()));
            }

            if ($request->input('playedUp')) {
                return $this->respond(new PlayerCollection(Player::with(['team', 'playedUps'])->orderBy('surname')->get()));
            }

            return $this->respond(new PlayerCollection(Player::all()));
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
            $newPlayer->played_up_count = $player['playedUpCount'] ?? 0;
            $newPlayer->team_id = $player['teamId'];
            $newPlayer->save();
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
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
