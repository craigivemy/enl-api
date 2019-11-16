<?php

namespace App\Http\Controllers;

use App\Season;
use Illuminate\Database\Schema\Builder;
use Illuminate\Http\Request;
use App\Division;
use App\Http\Resources\Division as DivisionResource;
use App\Http\Resources\DivisionCollection;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class DivisionController extends ApiController
{
    /**
     * Display a listing of divisions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
//            if ($request->query('current') === '1') {
//                return $this->respond(new DivisionCollection(
//                    Division::whereHas('seasons', function($q) {
//                        $q->where('current', '=', 1);
//                    })->get()
//                ));
//            }

            if ($seasonId = $request->input('seasonId')) {
                $season = Season::findOrFail($seasonId);

                $divisionIdsQuery = $season->divisions()
                    ->select('divisions.id')
                    ->groupBy('divisions.id')
                    ->getQuery();

                $divisions = Division::whereIn('id', $divisionIdsQuery)
                    ->with(['teams' => function ($query) use ($season) {
                        $query->where('season_id', $season->id);
                    }])
                    ->get();

                return $this->respond(new DivisionCollection($divisions));
            } else {
                return $this->respond(new DivisionCollection(Division::all()));
            }

        } catch (Throwable $t) {
            $meta = ['action' => 'DivisionController@index'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Store a newly created division in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $division = Division::create($request->all());
            return $this->respondCreated($division);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                $message = 'A division with that name already exists.';
                $meta = [
                    'action' => 'DivisionController@store',
                    'info'   => 'Creating division named: ' . $request->input('name')
                ];
                $this->logger->log('info', $e->getMessage(), ['exception' => $e, 'meta' => $meta]);
                return $this->respondDuplicateEntry($message);
            }
        } catch (Throwable $t) {
            $meta = ['action' => 'DivisionController@store'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Display the specified division.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return $this->respond(new DivisionResource(Division::findOrFail($id)));
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Division not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'DivisionController@show'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Update the specified division in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $division = Division::findOrFail($id);
            $division->fill($request->except('id'));
            $division->save();
            return $this->respondUpdated($division);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Division not found');
        } catch (Throwable $t) {
            $meta = [
                'action' => 'DivisionController@update',
                'info'   => 'Updating division named: ' . $request->input('name')
            ];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Soft deletes a division
     * (deleted_at value is set to timestamp)
     *
     * @param $id
     * @return ApiController|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function softDelete($id) {
        try {
            Division::destroy($id);
            return $this->respondSoftDeleted();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Division not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'DivisionController@softDelete'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Remove the specified division from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $division = Division::withTrashed()->where('id', $id)->first();
            if (!$division) {
                throw new ModelNotFoundException();
            }
            $division->forceDelete();
            return $this->respondDestroyed();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Division not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'DivisionController@destroy'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }
}
