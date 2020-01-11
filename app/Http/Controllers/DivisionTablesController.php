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
        $settings = DB::table('settings')->get()->keyBy('name');
        $win_value = $settings->get('win_value')->setting_value;
        $loss_value = $settings->get('loss_value')->setting_value;
        $draw_value = $settings->get('draw_value')->setting_value;
        $within5PointsBonusValue = $settings->get('bonus_point_within_5_value')->setting_value;
        $overHalfPointsBonusValue = $settings->get('bonus_point_over_50_percent_value')->setting_value;

            $teams = DB::select(DB::raw(
                "SELECT
                t.id as id, 
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
                ) tpa ON t.id = tpa.team_id AND (tpa.season_id = ? OR tpa.season_id IS NULL)
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
                            WHEN home_score > away_score THEN ? 
                            WHEN home_score = away_score THEN ?
                            WHEN home_score + 5 >= away_score THEN ?
                            WHEN away_score / 2 < home_score THEN ?
                            ELSE ?
                        END points
                    FROM matches mat WHERE played = 1 AND season_id = ?
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
                            WHEN home_score < away_score THEN ?
                            WHEN home_score = away_score THEN ? 
                            WHEN away_score + 5 >= home_score THEN ?
                            WHEN home_score / 2 < away_score THEN ?
                            ELSE ? 
                        END
                    FROM matches
                    WHERE played = 1 AND season_id = ?
                    ) AS total ON total.team_name=t.id WHERE dst.season_id = ?
                    GROUP BY dst.division_id, t.id
                    ORDER BY dst.division_id ASC, points DESC, goal_difference DESC"
            ), [
                $season_id,
                $win_value,
                $draw_value,
                $within5PointsBonusValue,
                $overHalfPointsBonusValue,
                $loss_value,
                $season_id,
                $win_value,
                $draw_value,
                $within5PointsBonusValue,
                $overHalfPointsBonusValue,
                $loss_value,
                $season_id,
                $season_id
            ]);

        return $this->respond([
            'data' => $teams
        ]);

        }

    /**
     * Display the specified resource.
     *
     * @param  int  $division_id
     * @return \Illuminate\Http\Response
     */
    public function show($division_id, Request $request)
    {
        // todo - only use this for main site team page

        $season_id = $request->input('seasonId');
        $settings = DB::table('settings')->get()->keyBy('name');
        $win_value = $settings->get('win_value')->setting_value;
        $loss_value = $settings->get('loss_value')->setting_value;
        $draw_value = $settings->get('draw_value')->setting_value;
        $within5PointsBonusValue = $settings->get('bonus_point_within_5_value')->setting_value;
        $overHalfPointsBonusValue = $settings->get('bonus_point_over_50_percent_value')->setting_value;

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
                ) tpa ON t.id = tpa.team_id AND (tpa.season_id = ? OR tpa.season_id IS NULL)
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
                            WHEN home_score > away_score THEN ? 
                            WHEN home_score = away_score THEN ?
                            WHEN home_score + 5 >= away_score THEN ?
                            WHEN away_score / 2 < home_score THEN ?
                            ELSE ?
                        END points
                    FROM matches mat WHERE played = 1 AND season_id = ? AND division_id = ?
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
                            WHEN home_score < away_score THEN ?
                            WHEN home_score = away_score THEN ? 
                            WHEN away_score + 5 >= home_score THEN ?
                            WHEN home_score / 2 < away_score THEN ?
                            ELSE ? 
                        END
                    FROM matches
                    WHERE played = 1 AND season_id = ? AND division_id = ?
                    ) AS total ON total.team_name=t.id WHERE dst.season_id = ? AND dst.division_id = ?
                    GROUP BY t.id
                    ORDER BY points DESC, goal_difference DESC"
        ), [
            $season_id,
            $win_value,
            $draw_value,
            $within5PointsBonusValue,
            $overHalfPointsBonusValue,
            $loss_value,
            $season_id,
            $division_id,
            $win_value,
            $draw_value,
            $within5PointsBonusValue,
            $overHalfPointsBonusValue,
            $loss_value,
            $season_id,
            $division_id,
            $season_id,
            $division_id
        ]);
        return $this->respond([
            'data' => $teams
        ]);

    }
}
