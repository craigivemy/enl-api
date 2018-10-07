<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Http\Resources\Team as TeamResource;
use App\Http\Resources\TeamCollection;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class TeamController extends ApiController
{
    /**
     * Display a listing of teams.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return $this->respond(new TeamCollection(Team::all()));
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
            $team = Team::create($request->all());
            return $this->respondCreated($team);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
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
    public function update(Request $request, $id)
    {
        try {
            $team = Team::findOrFail($id);
            $team->fill($request->except('id'));
            $team->save();
            return $this->respondUpdated($team);
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
