<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Match;
use App\Http\Resources\Match as FixtureResource;
use App\Http\Resources\MatchCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class MatchController extends ApiController
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

                return $this->respond(new MatchCollection(Match::with(['homeTeam', 'awayTeam'])
                    ->where('season_id', $request->query('seasonId'))
                    ->orderBy('match_date')
                    ->get()));

            }
            return $this->respond(new MatchCollection(Match::all()));
        } catch (Throwable $t) {
            $meta = ['action' => 'MatchController@index'];
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
            $fixture = Match::create($request->all());
            return $this->respondCreated($fixture);
        } catch (Throwable $t) {
            $meta = ['action' => 'MatchController@store'];
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
            return $this->respond(new FixtureResource(Match::findOrFail($id)));
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Match not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'MatchController@show'];
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
            $match = Match::findOrFail($id);
            if ($request->input('homeScore')) {
                $match->home_score = $request->input('homeScore');
            }
            if ($request->input('awayScore')) {
                $match->away_score = $request->input('awayScore');
            }
            $is_home_walkover = $request->input('walkoverHome');
            if (isset($is_home_walkover)) {
                $match->walkover_home = $request->input('walkoverHome');
            }
            $is_away_walkover = $request->input('walkoverHome');
            if (isset($is_away_walkover)) {
                $match->walkover_away = $request->input('walkoverAway');
            }
            $match->save();
            return $this->respondUpdated($match);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Match not found');
        } catch (Throwable $t) {
            $meta = [
                'action' => 'MatchController@update',
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
     * Remove the specified fixture from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $fixture = Match::withTrashed()->where('id', $id)->first();
            if (!$fixture) {
                throw new ModelNotFoundException();
            }
            $fixture->forceDelete();
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
