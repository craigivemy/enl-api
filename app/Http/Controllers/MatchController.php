<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Match;
use App\Http\Resources\Match as MatchResource;
use App\Http\Resources\MatchCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class MatchController extends ApiController
{
    /**
     * Display a listing of matches.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return $this->respond(new MatchCollection(Match::all()));
        } catch (Throwable $t) {
            $meta = ['action' => 'MatchController@index'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Store a newly created match in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $match = Match::create($request->all());
            return $this->respondCreated($match);
        } catch (Throwable $t) {
            $meta = ['action' => 'MatchController@store'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Display the specified match.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return $this->respond(new MatchResource(Match::findOrFail($id)));
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Match not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'MatchController@show'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Update the specified match in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $match = Match::findOrFail($id);
            $match->fill($request->except('id'));
            $match->save();
            return $this->respondUpdated($match);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Match not found');
        } catch (Throwable $t) {
            $meta = [
                'action' => 'MatchController@update',
                'info'   => 'Updating match ID: ' . $id
            ];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Soft deletes a match
     * (deleted_at value is set to timestamp)
     *
     * @param $id
     * @return ApiController|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function softDelete($id) {
        try {
            Match::destroy($id);
            return $this->respondSoftDeleted();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Match not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'MatchController@softDelete'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Remove the specified match from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $match = Match::withTrashed()->where('id', $id)->first();
            if (!$match) {
                throw new ModelNotFoundException();
            }
            $match->forceDelete();
            return $this->respondDestroyed();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Match not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'MatchController@destroy'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }
}
