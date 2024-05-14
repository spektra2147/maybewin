<?php namespace App\Repository\Interfaces;

interface FixtureRepositoryInterface
{
    public function countMatchesPlayed($teamId): int;

    public function countWins($teamId): int;

    public function countLosses($teamId): int;

    public function getThisWeek();

    public function getAllWeeks();

    public function getByWeekNumber(int $weekNumber);

    public function totalGoalsAtHome($teamId): int;

    public function totalGoalsNotAtHome($teamId): int;

    public function totalGoalsAgainstAtHome($teamId): int;

    public function totalGoalsAgainstNotAtHome($teamId): int;
}
