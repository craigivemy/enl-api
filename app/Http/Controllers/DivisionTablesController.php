<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DivisionTablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $season_id = $request->input('seasonId');
        $division_id = $request->input('divisionId');
        // use season_id, division_id to get results for those seasons
        // group by home_id?, then away id???
        $settings = DB::table('settings')->get()->keyBy('name');
        $win_value = $settings->get('win_value')->setting_value;
        $loss_value = $settings->get('loss_value')->setting_value;
        $draw_value = $settings->get('draw_value')->setting_value;
        $bonus_value = $settings->get('bonus_point_value')->setting_value;

        $teams = DB::select(DB::raw(
            "SELECT 
                    t.name AS Team,
                    IFNULL(SUM(WINS), 0) AS WINS,
                    IFNULL(SUM(DRAWS), 0) AS DRAWS,
                    IFNULL(SUM(LOSSES), 0) AS LOSSES,
                    IFNULL(SUM(GOALS_FOR), 0) AS GOALS_FOR,
                    IFNULL(SUM(GOALS_AGAINST), 0) AS GOALS_AGAINST,

                    IFNULL(SUM(GOAL_DIFFERENCE), 0) as GOAL_DIFFERENCE,
                    IFNULL(SUM(GAMES_PLAYED), 0) AS GAMES_PLAYED,
                    IFNULL(SUM(POINTS), 0) as POINTS
                    FROM teams t
                    LEFT JOIN (
                        SELECT home_id
                            Team,
                            IF(home_SCORE > away_score, 1,0) WINS,
                            IF(home_score = away_score, 1,0) DRAWS,
                            IF(home_score < away_score, 1,0) LOSSES,
                            home_score GOALS_FOR,
                            away_score GOALS_AGAINST,
                            home_score - away_score GOAL_DIFFERENCE,
                            1 GAMES_PLAYED,
                            CASE WHEN home_score > away_score THEN 5 WHEN home_score = away_score THEN 2 ELSE 0 END POINTS
                        FROM matches WHERE played = 1 AND season_id = 1 AND division_id = 2
                        
                        UNION ALL 
                        SELECT away_id,
                            
                            IF(home_score < away_score, 1, 0),
                            IF(home_score = away_score, 1,0),
                            IF(home_score > away_score, 1,0),
                            home_score,
                            away_score,
                            away_score - home_score GOAL_DIFFERENCE,
                            1 GAMES_PLAYED,
                            CASE WHEN home_score < away_score THEN 5 WHEN home_score = away_score THEN 2 ELSE 0 END
                        FROM matches
                        WHERE played = 1 AND season_id = 1 AND division_id = 2
                    ) AS total ON total.Team=t.id
                    
                    GROUP BY t.name
                    ORDER BY SUM(POINTS) DESC, GOAL_DIFFERENCE DESC"
        ));

        return $teams;

// todo - check OK to use variables here as from other DB fields
        // todo - select home_team or home_id is that right?
        // group by division id needed? Maybe better to rtetrieve all at once and use this? Or actually what about when only need one?
        // what does the 1 do in 2nd query?
//                  IFNULL(SUM(BONUS_POINTS), 0) as BONUS_POINTS,

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
