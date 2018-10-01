<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Logging\CustomLogger;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Club;
use App\Http\Resources\Club as ClubResource;
use App\Http\Resources\ClubCollection;

//use Bugsnag\PsrLogger\BugsnagLogger;

//use Bugsnag\BugsnagLaravel\Facades\Bugsnag;

class ClubController extends ApiController
{

    protected $logger;

    public function __construct(CustomLogger $customLogger)
    {
        $this->logger = $customLogger;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ClubCollection
     */
    public function index()
    {
        try {
            return $this->respond(new ClubCollection(Club::all()));
        } catch (\Throwable $t) {
            $meta = ['action' => 'ClubController@index'];
            $this->logger->log('alert', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError('Internal error');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
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
        } catch (\Throwable $t) {
            $meta = ['action'   => 'ClubController@show'];
            $this->logger->log('alert', $t->getMessage, ['exception' => $t, 'meta'  => $meta]);
            return $this->respondWithError('Internal error');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
