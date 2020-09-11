<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Umpire;
use App\Http\Resources\Umpire as UmpireResource;
use App\Http\Resources\UmpireCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class UmpireController extends ApiController
{
    /**
     * Display a listing of umpires.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // todo - admin flag returns phone and email, main site won't
        try {
            return $this->respond(new UmpireCollection(Umpire::all()));
        } catch (Throwable $t) {
            $meta = ['action' => 'UmpireController@index'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Store a newly created umpire in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $umpire_details = $request->input('umpire');
            $umpire = Umpire::create($umpire_details);
            return $this->respondCreated($umpire);
        } catch (Throwable $t) {
            $meta = ['action' => 'UmpireController@store'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Display the specified umpire.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return $this->respond(new UmpireResource(Umpire::findOrFail($id)));
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Umpire not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'UmpireController@show'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Update the specified umpire in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $umpire = Umpire::findOrFail($id);
            $changes = $request->input('umpire');
            $umpire->fill($changes);
            $umpire->save();
            return $this->respondUpdated($umpire);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Umpire not found');
        } catch (Throwable $t) {
            $meta = [
                'action' => 'UmpireController@update',
                'info'   => 'Updating umpire named: ' . $request->input('name')
            ];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Soft deletes an umpire
     * (deleted_at value is set to timestamp)
     *
     * @param $id
     * @return ApiController|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function softDelete($id) {
        try {
            Umpire::destroy($id);
            return $this->respondSoftDeleted();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Umpire not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'UmpireController@softDelete'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Remove the specified umpire from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $umpire = Umpire::withTrashed()->where('id', $id)->first();
            if (!$umpire) {
                throw new ModelNotFoundException();
            }
            $umpire->forceDelete();
            return $this->respondDestroyed();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Umpire not found');
        } catch (Throwable $t) {
            $meta = ['action'   => 'UmpireController@destroy'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError();
        }
    }
}
