<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Season;
use App\Http\Resources\Season as SeasonResource;
use App\Http\Resources\SeasonCollection;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class SeasonController extends ApiController
{
    /**
     * Display a listing of seasons.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
            $season = Season::create($request->all());
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
