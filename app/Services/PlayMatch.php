<?php namespace App\Services;

use App\Repository\Interfaces\FixtureRepositoryInterface;
use App\Repository\Interfaces\TeamRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PlayMatch
{
    public function play(Collection $fixtures)
    {
        foreach ($fixtures as $fixture) {
            $homeTeamGoals = rand(0, 3);
            $awayTeamGoals = rand(0, 3);

            $fixture->update([
                'home_team_goals' => $homeTeamGoals,
                'away_team_goals' => $awayTeamGoals,
            ]);
        }
    }

    public function updateStandings()
    {
        $fixtureRepository = app(FixtureRepositoryInterface::class);
        $teamRepository = app(TeamRepositoryInterface::class);
        $teams = $teamRepository->getAllTeams();

        foreach ($teams as $team) {
            $teamID = $team->getId();

            $matchesPlayed = $fixtureRepository->countMatchesPlayed($teamID);

            $wins = $fixtureRepository->countWins($teamID);

            $losses = $fixtureRepository->countLosses($teamID);

            $draws = $matchesPlayed - $wins - $losses;

            $goalsFor = $fixtureRepository->totalGoalsAtHome($teamID) + $fixtureRepository->totalGoalsNotAtHome($teamID);

            $goalsAgainst = $fixtureRepository->totalGoalsAgainstAtHome($teamID) + $fixtureRepository->totalGoalsAgainstNotAtHome($teamID);

            $goalDifference = $goalsFor - $goalsAgainst;

            $points = ($wins * 3) + ($draws * 1);

            $team->update([
                'played' => $matchesPlayed,
                'won' => $wins,
                'lost' => $losses,
                'drawn' => $draws,
                'goal_difference' => $goalDifference,
                'points' => $points,
            ]);
        }
    }
}


