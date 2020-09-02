<?php

namespace App\Http\Controllers;

use App\Match;
use App\Season;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $season_id = $request->input('seasonId');
        $season = Season::find($season_id);
        // todo if team id, get the below for a team
        if ($request->input('basicStats')) {
            // needs where date is later than today
            $next_match_and_datetime = Match::where('season_id', $season_id)
                ->where('played', 0)
                ->with('homeTeam', 'awayTeam')
                ->orderBy('match_date', 'asc')
                ->pluck('match_date')
                ->first();

            $teams_in_season = $season->teams()->count();

            $rounds_in_season = $season->rounds;

            $goals_in_season = DB::table('matches')
                ->selectRaw("SUM(home_score) + SUM(away_score) as total")
                ->whereRaw("season_id=? AND walkover_home=0 AND walkover_away=0", [$season_id])
                ->get();
            $goals_in_season = $goals_in_season->pluck('total')[0];

            $matches_played_in_season = DB::table('matches')
                ->selectRaw('COUNT(*) as total')
                ->whereRaw("season_id=? AND played=1", [$season_id])
                ->get();
            $matches_played_in_season = $matches_played_in_season->pluck("total")[0];

            // todo - number of players too - then front end can work out number of players not played up, too
            return [
                'data' => [
                    'nextMatchAndDatetime' => $next_match_and_datetime,
                    //'gameWeeksLeft'   => $game_weeks_left,
                    'teamsInSeason'   => $teams_in_season,
                    'roundsInSseason'  => $rounds_in_season,
                    'goalsInSeason'   => $goals_in_season,
                    'matchesPlayedInSeason' => $matches_played_in_season
                ]
            ];
        }

        if ($request->input('basicAdminStats')) {
            $next_match_and_datetime = Match::where('season_id', $season_id)
                ->where('played', 0)
                ->with('homeTeam', 'awayTeam')
                ->orderBy('match_date', 'asc')
                ->pluck('match_date')
                ->first();

            $teams_in_season = $season->teams()->count();

            $rounds_in_season = $season->rounds;

            $goals_in_season = DB::table('matches')
                ->selectRaw("SUM(home_score) + SUM(away_score) as total")
                ->whereRaw("season_id=? AND walkover_home=0 AND walkover_away=0", [$season_id])
                ->get();
            $goals_in_season = $goals_in_season->pluck('total')[0];

            $matches_played_in_season = DB::table('matches')
                ->selectRaw('COUNT(*) as total')
                ->whereRaw("season_id=? AND played=1", [$season_id])
                ->get();
            $matches_played_in_season = $matches_played_in_season->pluck("total")[0];

            $playedUpStats = [];
            $playedUpStats['once'] = DB::table('played_ups')
                ->selectRaw("player_id, COUNT(*) c")
                ->groupBy(DB::raw("player_id HAVING c = 1"))
                ->whereRaw("season_id=?", [$season_id])
                ->get();
            $playedUpStats['once'] = count($playedUpStats['once']);

            $playedUpStats['twice'] = DB::table('played_ups')
                ->selectRaw("player_id, COUNT(*) c")
                ->groupBy(DB::raw("player_id HAVING c = 2"))
                ->whereRaw("season_id=?", [$season_id])
                ->get();
            $playedUpStats['twice'] = count($playedUpStats['twice']);

            $playedUpStats['moreThanTwice'] = DB::table('played_ups')
                ->selectRaw("player_id, COUNT(*) c")
                ->groupBy(DB::raw("player_id HAVING c = 2"))
                ->whereRaw("season_id=?", [$season_id])
                ->get();
            $playedUpStats['moreThanTwice'] = count($playedUpStats['moreThanTwice']);

            return [
                'data' => [
                    'nextMatchAndDatetime' => $next_match_and_datetime,
                    //'gameWeeksLeft'   => $game_weeks_left,
                    'teamsInSeason'   => $teams_in_season,
                    'roundsInSseason'  => $rounds_in_season,
                    'goalsInSeason'   => $goals_in_season,
                    'matchesPlayedInSeason' => $matches_played_in_season,
                    'playedUpStats' => $playedUpStats
                ]
            ];
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
