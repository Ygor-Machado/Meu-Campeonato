<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            ['nome' => 'Team 1', 'campeonato_id' => 1],
            ['nome' => 'Team 2', 'campeonato_id' => 1],
            ['nome' => 'Team 3', 'campeonato_id' => 1],
            ['nome' => 'Team 4', 'campeonato_id' => 1],
            ['nome' => 'Team 5', 'campeonato_id' => 1],
            ['nome' => 'Team 6', 'campeonato_id' => 1],
            ['nome' => 'Team 7', 'campeonato_id' => 1],
            ['nome' => 'Team 8', 'campeonato_id' => 1],
        ];

        DB::table('times')->insert($teams);
    }
}
