<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ranks = [
            ['id' => 1, 'name' => 'Trainee'],
            ['id' => 2, 'name' => 'Employee'],
            ['id' => 3, 'name' => 'Ausbilder'],
            ['id' => 4, 'name' => 'Chief Executive Officer'],
        ];

        foreach ($ranks as $rank) {
            Rank::create($rank);
        }
    }
}
