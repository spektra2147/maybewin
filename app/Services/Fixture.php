<?php namespace App\Services;

use App\Models\Team;

class Fixture
{
    public function generate($teams)
    {
        $teamCount = count($teams);

        $fixtures = [];

        shuffle($teams);

        for ($week = 1; $week <= 6; $week++) {
            $weekFixtures = [];

            for ($i = 0; $i < $teamCount / 2; $i++) {
                $z = $i;

                if ($week > 4) {
                    $z += ($i == 0) ? 1 : ($i == 1 ? -1 : 0);
                }

                $team1 = $teams[$i];
                $team2 = $teams[$teamCount - $z - 1];

                if ($week > 5 && $i > 0) {
                    [$team1, $team2] = [$team2, $team1];
                }

                $weekFixtures[] = [
                    'home_team_id' => $team1,
                    'away_team_id' => $team2,
                    'week_number' => $week,
                ];
            }

            $fixtures = array_merge($fixtures, $weekFixtures);

            $lastTeam = array_pop($teams);
            array_unshift($teams, $lastTeam);
        }

        return $fixtures;
    }

    public function championProbabilities($teams)
    {
        $totalPoints = $teams->sum('points');

        foreach ($teams as $team) {
            $points = $team->points;

            $probability = ($points / $totalPoints);
            $probability *= 100;

            $team->probability = $probability;
        }

        return $teams->sortsByDesc('probability')
            ->select(['name', 'probability', 'goal_difference'])
            ->values();
    }
}


