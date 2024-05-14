<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'points',
        'played',
        'won',
        'lost',
        'drawn',
        'goal_difference',
    ];

    public function getId()
    {
        return $this->id;
    }
}
