<?php namespace App\Repository;

use App\Models\Team;
use App\Repository\Interfaces\TeamRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class TeamRepository implements TeamRepositoryInterface
{
    private Model $model;

    public function __construct(Team $model)
    {
        $this->model = $model;
    }

    public function getAllTeams()
    {
        return $this->model->all();
    }

    public function resetValues()
    {
        return $this->model->query()->update([
            'played' => 0,
            'won' => 0,
            'lost' => 0,
            'drawn' => 0,
            'goal_difference' => 0,
            'points' => 0,
        ]);
    }
}
