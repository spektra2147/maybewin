<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = ['Real Madrid', 'FC Barcelona', 'Paris Saint-Germain FC', 'Atletico Madrid',];

        foreach ($teams as $teamName) {
            Team::create(['name' => $teamName]);
        }
    }
}
