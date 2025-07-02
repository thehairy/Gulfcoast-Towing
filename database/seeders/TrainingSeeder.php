<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Training;

class TrainingSeeder extends Seeder
{
    public function run(): void
    {
        $trainings = [
            [
                'name' => 'Grundausbildung',
                'code' => 'GA',
                'description' => 'Grundlegende Ausbildung für alle Mitarbeiter',
                'is_required' => true,
            ],
            [
                'name' => 'Erste-Hilfe-Schein',
                'code' => 'EH',
                'description' => 'Erste-Hilfe-Ausbildung für Notfälle',
                'is_required' => true,
            ],
            [
                'name' => 'Funklehrgang',
                'code' => 'FL',
                'description' => 'Ausbildung für die Funknutzung',
                'is_required' => false,
            ],
            [
                'name' => 'Abschlepplehrgang',
                'code' => 'ABL',
                'description' => 'Ausbildung für Abschleppfahrzeuge',
                'is_required' => false,
            ],
            [
                'name' => 'Kranlehrgang',
                'code' => 'KRA',
                'description' => 'Ausbildung für Kranfahrzeuge',
                'is_required' => false,
            ],
            [
                'name' => 'Werkstattlehrgang',
                'code' => 'WRK',
                'description' => 'Ausbildung für Werkstattarbeiten',
                'is_required' => false,
            ],
            [
                'name' => 'Leitstellenlehrgang',
                'code' => 'LST',
                'description' => 'Ausbildung für Leitstellentätigkeiten',
                'is_required' => false,
            ],
        ];

        foreach ($trainings as $training) {
            Training::create($training);
        }
    }
}
