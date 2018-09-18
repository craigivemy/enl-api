<?php

namespace App\Http\Controllers;

use App\Umpire;
use App\Http\Resources\Umpire as UmpireResource;
use App\Http\Resources\UmpireCollection;

use Illuminate\Http\Request;

class UmpireController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UmpireCollection(Umpire::all());
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
     * @param  \App\Umpire  $umpire
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UmpireResource(Umpire::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Umpire  $umpire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Umpire $umpire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Umpire  $umpire
     * @return \Illuminate\Http\Response
     */
    public function destroy(Umpire $umpire)
    {
        //
    }
}
