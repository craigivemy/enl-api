<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Club;
use App\Http\Resources\Club as ClubResource;
use App\Http\Resources\ClubCollection;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class ClubController extends ApiController
{
    /**
     * Display a listing of clubs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return $this->respond(new ClubCollection(Club::all()));
        } catch (Throwable $t) {
            $meta = ['action' => 'ClubController@index'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Store a newly created club in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $club = Club::create($request->all());
            return $this->respondCreated($club);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                $message = 'A club with that name already exists.';
                $meta = [
                    'action' => 'ClubController@store',
                    'info'   => 'Creating club named: ' . $request->input('name')
                ];
                $this->logger->log('info', $e->getMessage(), ['exception' => $e, 'meta' => $meta]);
                return $this->respondDuplicateEntry($message);
            }
        } catch (Throwable $t) {
            $meta = ['action' => 'ClubController@store'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Display the specified club.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return $this->respond(new ClubResource(Club::findOrFail($id)));
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Club not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'ClubController@show'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Update the specified club in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $club = Club::findOrFail($id);
            $club->fill($request->except('id'));
            $club->save();
            return $this->respondUpdated($club);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Club not found');
        } catch (Throwable $t) {
            $meta = [
                'action' => 'ClubController@update',
                'info'   => 'Updating club named: ' . $request->input('name')
            ];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Soft deletes a club
     * (deleted_at value is set to timestamp)
     * @param $id
     * @return ApiController|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function softDelete($id) {
        try {
            Club::destroy($id);
            return $this->respondSoftDeleted();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Club not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'ClubController@softDelete'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Remove the specified club from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $club = Club::withTrashed()->where('id', $id)->first();
            if (!$club) {
                throw new ModelNotFoundException();
            }
            $club->forceDelete();
            return $this->respondDestroyed();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Club not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'ClubController@destroy'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }
}
