<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use App\Models\Team;
use App\Repository\Interfaces\FixtureRepositoryInterface;
use App\Services\PlayMatch;
use Justfeel\Response\ResponseCodes;
use Justfeel\Response\ResponseResult;

class ApiController extends Controller
{
    public function getTeamList()
    {
        $teams = Team::all();
        return response()->json(['success' => true, 'data' => $teams], ResponseCodes::HTTP_OK);
    }

    public function generateFixture()
    {
        $teams = Team::all()->pluck('id')->toArray();

        $fixtures = (new \App\Services\Fixture())->generate($teams);

        Fixture::insert($fixtures);

        return ResponseResult::generate(true, 'Fixture generated!', ResponseCodes::HTTP_CREATED);
    }

    public function play(FixtureRepositoryInterface $fixtureRepository, PlayMatch $playMatch)
    {
        $fixtures = $fixtureRepository->getThisWeek();

        if (!count($fixtures)) {
            return ResponseResult::generate(true, 'All matches played', ResponseCodes::HTTP_OK);
        }

        $playMatch->play($fixtures);

        $playMatch->updateStandings();

        return ResponseResult::generate(true, 'Matches played successfully!', ResponseCodes::HTTP_CREATED);
    }

    public function playAll(FixtureRepositoryInterface $fixtureRepository, PlayMatch $playMatch)
    {
        $allWeeks = $fixtureRepository->getAllWeeks();

        foreach ($allWeeks as $week) {
            $fixtures = $fixtureRepository->getByWeekNumber($week->week_number);

            $playMatch->play($fixtures);
        }

        $playMatch->updateStandings();

        return ResponseResult::generate(true, 'All matches played', ResponseCodes::HTTP_OK);
    }

    public function reset()
    {
        Fixture::truncate();

        Team::query()->update([
            'played' => 0,
            'won' => 0,
            'lost' => 0,
            'drawn' => 0,
            'goal_difference' => 0,
            'points' => 0,
        ]);

        return ResponseResult::generate(true, 'All data removed', ResponseCodes::HTTP_OK);
    }

    public function championsProbabilities(\App\Services\Fixture $fixture)
    {
        $teams = Team::all();
        $values = $fixture->championProbabilities($teams);

        return response()->json($values);
    }

}
