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
            ['id' => 1, 'name' => 'Recovery Associate'],
            ['id' => 2, 'name' => 'Recovery Specialist'],
            ['id' => 3, 'name' => 'Senior Recovery Specialist'],
            ['id' => 4, 'name' => 'Training & Development Manager'],
            ['id' => 5, 'name' => 'Director of Operations'],
            ['id' => 6, 'name' => 'Chief Executive Officer'],
        ];

        foreach ($ranks as $rank) {
            Rank::create($rank);
        }
    }
}
