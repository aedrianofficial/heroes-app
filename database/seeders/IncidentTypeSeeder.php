<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\IncidentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncidentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Define Incident Types
         $incidentTypes = [
            'CRIME',
            'ROAD',
            'HEALTH',
            'DISASTER',
            'SEA',
            'FIRE'
        ];

        // Insert Incident Types and store references
        $incidentTypeIds = [];
        foreach ($incidentTypes as $incident) {
            $incidentTypeIds[$incident] = IncidentType::firstOrCreate(['name' => $incident])->id;
        }

        // Define agency and their responsibilities
        $agencyIncidentMapping = [
            'PNP' => ['CRIME', 'ROAD','FIRE','DISASTER'],
            'BFP' => ['CRIME', 'ROAD','FIRE','DISASTER'],
            'MDRRMO' => ['CRIME', 'ROAD','FIRE','DISASTER'],
            'MHO' => ['HEALTH'],
            'COAST GUARD' => ['SEA'],
            'LGU' => ['ROAD', 'DISASTER', 'HEALTH']
        ];

        // Attach incident types to agencies
        foreach ($agencyIncidentMapping as $agencyName => $incidents) {
            $agency = Agency::where('name', $agencyName)->first();
            if ($agency) {
                $incidentTypeIdsToAttach = array_map(fn($incident) => $incidentTypeIds[$incident], $incidents);
                $agency->incidentTypes()->sync($incidentTypeIdsToAttach);
            }
        }
    }
}
