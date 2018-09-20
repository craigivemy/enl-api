<?php

namespace App\Http\Controllers;

use App\Team;
use App\Http\Resources\Team as TeamResource;
use App\Http\Resources\TeamCollection;
use Illuminate\Http\Request;

class TeamController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new TeamCollection(Team::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return TeamResource
     */
    public function show($id)
    {
        /* set correct status codes!!! */
        //return (new TeamResource(Team::find($id)))->response()->setStatusCode(400);
        return (new TeamResource(Team::with('club')->findOrFail($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
    }
}
