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


        if ($division_id) {
            $teams = DB::select(DB::raw(
                "SELECT 
                    t.name AS team_name,
                    t.id as team_id,
                    SUM(win) AS win,
                    SUM(draw) AS draw,
                    SUM(loss) AS loss,
                    SUM(goals_for) AS goals_for,
                    SUM(goals_against) AS goals_against,

                    SUM(goal_difference) as goal_difference,
                    SUM(games_played) AS games_played,
                    SUM(points) + IFNULL(tpa.point_adjustment, 0) as points
                    FROM teams t 
                    LEFT JOIN team_point_adjustments tpa
                        ON t.id = tpa.team_id
                        AND (tpa.season_id = '" . $season_id . "' OR tpa.season_id IS NULL)
                    INNER JOIN
                        division_season_team dst
                        ON t.id = dst.team_id
                    LEFT JOIN (
                        SELECT home_id
                            team_name,
                            IF(home_SCORE > away_score, 1,0) win,
                            IF(home_score = away_score, 1,0) draw,
                            IF(home_score < away_score, 1,0) loss,
                            home_score goals_for,
                            away_score goals_against,
                            home_score - away_score goal_difference,
                            1 games_played,
                            CASE WHEN home_score > away_score THEN '" . $win_value . "' WHEN home_score = away_score THEN '" . $draw_value . "' ELSE '" . $loss_value . "' END points
                        FROM matches mat WHERE played = 1 AND season_id = '" . $season_id . "' AND division_id = '" . $division_id . "'
                        
                        UNION ALL 
                        SELECT away_id,
                            
                            IF(home_score < away_score, 1, 0),
                            IF(home_score = away_score, 1,0),
                            IF(home_score > away_score, 1,0),
                            away_score,
                            home_score,
                            away_score - home_score goal_difference,
                            1 games_played,
                            CASE WHEN home_score < away_score THEN '" . $win_value . "' WHEN home_score = away_score THEN '" . $draw_value . "' ELSE '" . $loss_value . "' END
                        FROM matches
                        WHERE played = 1 AND season_id = '" . $season_id . "' AND division_id = '" . $division_id . "'
                        
                        ) AS total ON total.team_name=t.id WHERE dst.season_id = '" . $season_id . "' AND dst.division_id = '" . $division_id . "'
                    
                    GROUP BY t.id
                    ORDER BY ABS(points) + IFNULL(tpa.point_adjustment, 0) DESC, goal_difference DESC"
            ));
        } else {
            $teams = DB::select(DB::raw(
                "SELECT 
                    t.name AS team_name,
                    t.id as team_id,
                    SUM(win) AS win,
                    SUM(draw) AS draw,
                    SUM(loss) AS loss,
                    SUM(goals_for) AS goals_for,
                    SUM(goals_against) AS goals_against,

                    SUM(goal_difference) as goal_difference,
                    SUM(games_played) AS games_played,
                    SUM(points) as points
                    FROM teams t INNER JOIN
                        division_season_team dst
                        ON t.id = dst.team_id
                    LEFT JOIN (
                        SELECT home_id
                            team_name,
                            IF(home_SCORE > away_score, 1,0) win,
                            IF(home_score = away_score, 1,0) draw,
                            IF(home_score < away_score, 1,0) loss,
                            home_score goals_for,
                            away_score goals_against,
                            home_score - away_score goal_difference,
                            1 games_played,
                            CASE 
                                WHEN home_score > away_score THEN '" . $win_value . "' 
                                WHEN home_score = away_score THEN '" . $draw_value . "' 
                                ELSE '" . $loss_value . "' END points
                        FROM matches mat WHERE played = 1 AND season_id = '" . $season_id . "'
                        
                        UNION ALL 
                        SELECT away_id,
                            
                            IF(home_score < away_score, 1, 0),
                            IF(home_score = away_score, 1,0),
                            IF(home_score > away_score, 1,0),
                            away_score,
                            home_score,
                            away_score - home_score goal_difference,
                            1 games_played,
                            CASE 
                                WHEN home_score < away_score THEN '" . $win_value . "' 
                                WHEN home_score = away_score THEN '" . $draw_value . "' 
                                ELSE '" . $loss_value . "' END
                        FROM matches
                        WHERE played = 1 AND season_id = '" . $season_id . "'
                        
                        ) AS total ON total.team_name=t.id WHERE dst.season_id = '" . $season_id . "'
                    
                    GROUP BY t.id
                    ORDER BY dst.division_id, SUM(points) DESC, goal_difference DESC"
            ));
        }
        return $teams;

// todo - check OK to use variables here as from other DB fields
        // todo - select bonus points too, plus need to calculate home, away adjust and
        //  probably create table and join on it for reasons (or separate query from front end? - actually
        // home_adjust etc - should that be on teams table/jointable?
// todo - IFNULL(SUM(BONUS_POINTS), 0) as BONUS_POINTS,
        // todo - also need a season id column for settings then query above ->where('season_id') etc?


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
