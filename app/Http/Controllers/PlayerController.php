<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        try {
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
            $player = Player::create($request->all());
            return $this->respondCreated($player);
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
            $player->fill($request->except('id'));
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
