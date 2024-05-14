<?php namespace App\Repository;

use App\Models\Fixture;
use Illuminate\Database\Eloquent\Model;
use App\Repository\Interfaces\FixtureRepositoryInterface;

class FixtureRepository implements FixtureRepositoryInterface
{
    private Model $model;

    public function __construct(Fixture $model)
    {
        $this->model = $model;
    }

    public function countMatchesPlayed($teamId): int
    {
        return $this->model->where(function ($query) use ($teamId) {
            $query->where('home_team_id', $teamId)
                ->orWhere('away_team_id', $teamId);
        })
            ->whereNotNull('home_team_goals')
            ->count();
    }

    public function countWins($teamId): int
    {
        return $this->model->where(function ($query) use ($teamId) {
            $query->where('home_team_id', $teamId)
                ->whereColumn('home_team_goals', '>', 'away_team_goals');
        })->orWhere(function ($query) use ($teamId) {
            $query->where('away_team_id', $teamId)
                ->whereColumn('away_team_goals', '>', 'home_team_goals');
        })
            ->whereNotNull('home_team_goals')
            ->count();
    }

    public function countLosses($teamId): int
    {
        return $this->model->where(function ($query) use ($teamId) {
            $query->where('home_team_id', $teamId)
                ->whereColumn('home_team_goals', '<', 'away_team_goals');
        })
            ->orWhere(function ($query) use ($teamId) {
                $query->where('away_team_id', $teamId)
                    ->whereColumn('away_team_goals', '<', 'home_team_goals');
            })
            ->whereNotNull('home_team_goals')
            ->count();
    }

    public function getThisWeek()
    {
        return $this->model
            ->whereNull('home_team_goals')
            ->limit(2)
            ->get();
    }

    public function getAllWeeks()
    {
        return $this->model
            ->whereNull('home_team_goals')
            ->groupBy('week_number')
            ->select('week_number')
            ->get();
    }

    public function getByWeekNumber(int $weekNumber)
    {
        return $this->model->where('week_number', $weekNumber)
            ->get();
    }

    public function totalGoalsAtHome($teamId): int
    {
        return $this->model->where('home_team_id', $teamId)
            ->whereNotNull('home_team_goals')
            ->sum('home_team_goals');
    }

    public function totalGoalsNotAtHome($teamId): int
    {
        return $this->model->where('away_team_id', $teamId)
            ->whereNotNull('away_team_id')
            ->sum('away_team_goals');
    }

    public function totalGoalsAgainstAtHome($teamId): int
    {
        return $this->model->where('home_team_id', $teamId)
            ->whereNotNull('home_team_goals')
            ->sum('away_team_goals');
    }

    public function totalGoalsAgainstNotAtHome($teamId): int
    {
        return $this->model->where('away_team_id', $teamId)
            ->whereNotNull('away_team_id')
            ->sum('home_team_goals');
    }

    public function truncate()
    {
        return $this->model->truncate();
    }

    public function saveAll(array $values)
    {
        return $this->model->insert($values);
    }

    public function countAll()
    {
        return $this->model->all()->count();
    }
}
