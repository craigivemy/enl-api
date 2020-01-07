<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DivisionTablesController extends ApiController
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
                LEFT JOIN (
                  SELECT team_id, season_id, SUM(point_adjustment) AS point_adjustment
                  FROM team_point_adjustments
                  GROUP BY team_id, season_id
                ) tpa ON t.id = tpa.team_id AND (tpa.season_id = '" . $season_id . "' OR tpa.season_id IS NULL)
                LEFT JOIN division_season_team dst ON t.id = dst.team_id
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
                            ELSE '" . $loss_value . "' 
                        END points
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
                        CASE 
                            WHEN home_score < away_score THEN '" . $win_value . "' 
                            WHEN home_score = away_score THEN '" . $draw_value . "' 
                            ELSE '" . $loss_value . "' 
                        END
                    FROM matches
                    WHERE played = 1 AND season_id = '" . $season_id . "' AND division_id = '" . $division_id . "'
                    ) AS total ON total.team_name=t.id WHERE dst.season_id = '" . $season_id . "' AND dst.division_id = '" . $division_id . "'
                    GROUP BY t.id
                    ORDER BY points DESC, goal_difference DESC"
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
                SUM(points) + IFNULL(tpa.point_adjustment, 0) as points,
                dst.division_id as division_id
                FROM teams t 
                LEFT JOIN (
                  SELECT team_id, season_id, SUM(point_adjustment) AS point_adjustment
                  FROM team_point_adjustments
                  GROUP BY team_id, season_id
                ) tpa ON t.id = tpa.team_id AND (tpa.season_id = '" . $season_id . "' OR tpa.season_id IS NULL)
                LEFT JOIN division_season_team dst ON t.id = dst.team_id
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
                            ELSE '" . $loss_value . "' 
                        END points
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
                            ELSE '" . $loss_value . "' 
                        END
                    FROM matches
                    WHERE played = 1 AND season_id = '" . $season_id . "'
                    ) AS total ON total.team_name=t.id WHERE dst.season_id = '" . $season_id . "'
                    GROUP BY t.id
                    ORDER BY dst.division_id ASC, points DESC, goal_difference DESC"
            ));
        }
        return $this->respond($teams);

        // todo - calc half score / within 2 bonus point scores
        // todo - definite sql injection issue with divison id etc
        // todo - return as collection


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
