<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Logging\CustomLogger;
use Illuminate\Http\Request;
use App\Club;
use App\Http\Resources\Club as ClubResource;
use App\Http\Resources\ClubCollection;

//use Bugsnag\PsrLogger\BugsnagLogger;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;

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

        //$this->logger->critical('test');

        Bugsnag::notifyException(new \Exception('test'));

       // $this->logger->log('critical', 'test');

        /*
        try {
            return $this->respond(new ClubCollection(Club::all()));
        } catch (\Throwable $e) {
            return $this->respondWithError('Unknown error occurred');
            // $this->CustomLogger
        }
        */
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
        //return new ClubResource(Club::find($id));
        // club not found:

        return $this->respondNotFound('Club not found');

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
