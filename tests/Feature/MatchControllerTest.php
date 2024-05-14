<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Team;
use App\Models\Fixture;

class MatchControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test updating standings after playing matches.
     *
     * @return void
     */
    public function testUpdateStandings()
    {
        $teams = Team::factory()->count(4)->create();

        $teamCount = count($teams);

        for ($i = 0; $i < $teamCount / 2; $i++) {
            $team1 = $teams[$i];
            $team2 = $teams[$teamCount - $i - 1];

           $fixtures =  Fixture::factory()->create([
                'week_number' => 1,
                'home_team_id' => $team1,
                'away_team_id' => $team2
            ]);

            $matchResult = $this->generateMatchResult();

            $fixtures->update([
                'home_team_goals' => $matchResult['home_team_goals'],
                'away_team_goals' => $matchResult['away_team_goals']
            ]);
        }
    }

    function generateMatchResult() {
        $homeTeamGoals = rand(0, 5);
        $awayTeamGoals = rand(0, 3);

        return [
            'home_team_goals' => $homeTeamGoals,
            'away_team_goals' => $awayTeamGoals
        ];
    }
}
