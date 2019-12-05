<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Fixture;
use App\Http\Resources\Fixture as FixtureResource;
use App\Http\Resources\FixtureCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class FixtureController extends ApiController
{
    /**
     * Display a listing of fixtures.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->query('seasonId')) {

                return $this->respond(new FixtureCollection(Fixture::with(['homeTeam', 'awayTeam'])
                    ->where('season_id', $request->query('seasonId'))
                    //->where('played', '=', 0)
                    ->orderBy('match_date')
                    ->get()));

            }
            return $this->respond(new FixtureCollection(Fixture::all()));
        } catch (Throwable $t) {
            $meta = ['action' => 'FixtureController@index'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Store a newly created fixture in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $fixture = Fixture::create($request->all());
            return $this->respondCreated($fixture);
        } catch (Throwable $t) {
            $meta = ['action' => 'FixtureController@store'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Display the specified fixture.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return $this->respond(new FixtureResource(Fixture::findOrFail($id)));
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Fixture not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'FixtureController@show'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Update the specified fixture in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $fixture = Fixture::findOrFail($id);
            $fixture->fill($request->except('id'));
            $fixture->save();
            return $this->respondUpdated($fixture);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Fixture not found');
        } catch (Throwable $t) {
            $meta = [
                'action' => 'FixtureController@update',
                'info'   => 'Updating fixture ID: ' . $id
            ];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Soft deletes a fixture
     * (deleted_at value is set to timestamp)
     *
     * @param $id
     * @return ApiController|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function softDelete($id) {
        try {
            Fixture::destroy($id);
            return $this->respondSoftDeleted();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Fixture not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'FixtureController@softDelete'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Remove the specified fixture from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $fixture = Fixture::withTrashed()->where('id', $id)->first();
            if (!$fixture) {
                throw new ModelNotFoundException();
            }
            $fixture->forceDelete();
            return $this->respondDestroyed();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Fixture not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'FixtureController@destroy'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }
}
