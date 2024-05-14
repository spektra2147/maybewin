<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repository\Interfaces\FixtureRepositoryInterface;
use App\Repository\Interfaces\TeamRepositoryInterface;
use App\Services\PlayMatch;
use Justfeel\Response\ResponseCodes;
use Justfeel\Response\ResponseResult;

class ApiController extends Controller
{
    public function getTeamList(TeamRepositoryInterface $teamRepository)
    {
        $teams = $teamRepository->getAllTeams();
        return response()->json(['success' => true, 'data' => $teams], ResponseCodes::HTTP_OK);
    }

    public function generateFixture(TeamRepositoryInterface $teamRepository, FixtureRepositoryInterface $fixtureRepository)
    {
        $teams = $teamRepository->getAllTeams()->pluck('id')->toArray();

        $fixtures = (new \App\Services\Fixture())->generate($teams);

        $fixtureRepository->saveAll($fixtures);

        return ResponseResult::generate(true, 'Fixture generated!', ResponseCodes::HTTP_CREATED);
    }

    public function play(FixtureRepositoryInterface $fixtureRepository, PlayMatch $playMatch)
    {
        if (!$fixtureRepository->countAll()) {
            return ResponseResult::generate(false, 'Generate fixture', ResponseCodes::HTTP_BAD_REQUEST);
        }

        $fixtures = $fixtureRepository->getThisWeek();

        if (!count($fixtures)) {
            return ResponseResult::generate(false, 'All matches played', ResponseCodes::HTTP_OK);
        }

        $playMatch->play($fixtures);

        $playMatch->updateStandings();

        return ResponseResult::generate(true, 'Matches played successfully!', ResponseCodes::HTTP_CREATED);
    }

    public function playAll(FixtureRepositoryInterface $fixtureRepository, PlayMatch $playMatch)
    {
        if (!$fixtureRepository->countAll()) {
            return ResponseResult::generate(false, 'Generate fixture', ResponseCodes::HTTP_BAD_REQUEST);
        }

        $allWeeks = $fixtureRepository->getAllWeeks();

        if (!count($allWeeks)) {
            return ResponseResult::generate(false, 'All matches played', ResponseCodes::HTTP_OK);
        }

        foreach ($allWeeks as $week) {
            $fixtures = $fixtureRepository->getByWeekNumber($week->week_number);

            $playMatch->play($fixtures);
        }

        $playMatch->updateStandings();

        return ResponseResult::generate(true, 'All matches played', ResponseCodes::HTTP_OK);
    }

    public function reset(FixtureRepositoryInterface $fixtureRepository, TeamRepositoryInterface $teamRepository)
    {
        $fixtureRepository->truncate();

        $teamRepository->resetValues();

        return ResponseResult::generate(true, 'All data removed', ResponseCodes::HTTP_OK);
    }

    public function championsProbabilities(\App\Services\Fixture $fixture, TeamRepositoryInterface $teamRepository)
    {
        $teams = $teamRepository->getAllTeams();
        $values = $fixture->championProbabilities($teams);

        return response()->json($values);
    }

}
