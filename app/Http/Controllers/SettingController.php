<?php

namespace App\Http\Controllers;

use App\Http\Resources\SettingCollection;
use App\Season;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class SettingController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->input('seasonId')) {
            return $this->respond(new SettingCollection(Setting::where('season_id', $request->input('seasonId'))->get()));
        }
        $current_season_id = Season::where('current', 1)->pluck('id');
        return $this->respond(new SettingCollection(Setting::where('season_id', $current_season_id)->get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $setting = Setting::create($request->all());
            return $this->respondCreated($setting);
        } catch (Throwable $t) {
            $meta = ['action' => 'SettingController@store'];
            $this->logger->log('critical', $t->getMessage(), ['exception' => $t, 'meta' => $meta]);
            return $this->respondWithError();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
