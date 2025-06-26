<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = [
            [
                'name' => 'Pannenservice 1',
                'type' => 'PKW',
                'license_plate' => 'GCT-P01',
                'status' => 'available',
                'description' => 'Service-Fahrzeug für Kundenbesuche und kleine Erledigungen',
                'requires_special_license' => false,
                'capabilities' => ['customer_visits', 'documents', 'small_items'],
            ],
            [
                'name' => 'Pannenservice 2',
                'type' => 'PKW',
                'license_plate' => 'GCT-P01',
                'status' => 'available',
                'description' => 'Service-Fahrzeug für Kundenbesuche und kleine Erledigungen',
                'requires_special_license' => false,
                'capabilities' => ['customer_visits', 'documents', 'small_items'],
            ],
            [
                'name' => 'Abschleppwagen PKW',
                'type' => 'PKW',
                'license_plate' => 'GCT-A01',
                'status' => 'available',
                'description' => 'Abschleppwagen für PKW',
                'requires_special_license' => false,
                'capabilities' => ['customer_visits', 'documents', 'small_items'],
            ],
            [
                'name' => 'Abschleppwagen LKW',
                'type' => 'LKW',
                'license_plate' => 'GCT-A02',
                'status' => 'available',
                'description' => 'Abschleppwagen für LKW',
                'requires_special_license' => false,
                'capabilities' => ['customer_visits', 'documents', 'small_items'],
            ],
            [
                'name' => 'Kranwagen',
                'type' => 'Spezialfahrzeug',
                'license_plate' => 'GCT-K01',
                'status' => 'available',
                'description' => 'LKW mit Kran für schwere Hebevorgänge',
                'requires_special_license' => true,
                'capabilities' => ['customer_visits', 'documents', 'small_items'],
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }
    }
}
