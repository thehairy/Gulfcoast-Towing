<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create([
            'steam_id' => '76561198147896830',
            'first_name' => 'Sam',
            'last_name' => 'White',
            'phone_number' => '0659177288',
            'rank_id' => 6,
        ]);
        Employee::create([
            'steam_id' => '76561198363089682',
            'first_name' => 'Mike',
            'last_name' => 'Resse',
            'phone_number' => '0659177233',
            'rank_id' => 5,
        ]);
    }
}
