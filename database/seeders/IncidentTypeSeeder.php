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
            'ROAD ACCIDENT',
            'HEALTH EMERGENCY',
            'DISASTER',
            'SEA INCIDENT',
            'FIRE'
        ];

        // Insert Incident Types and store references
        $incidentTypeIds = [];
        foreach ($incidentTypes as $incident) {
            $incidentTypeIds[$incident] = IncidentType::firstOrCreate(['name' => $incident])->id;
        }

        // Define agency and their responsibilities
        $agencyIncidentMapping = [
            'PNP' => ['CRIME', 'ROAD ACCIDENT'],
            'BFP' => ['FIRE'],
            'MDRRMO' => ['DISASTER'],
            'MHO' => ['HEALTH EMERGENCY'],
            'COAST GUARD' => ['SEA INCIDENT'],
            'LGU' => ['ROAD ACCIDENT', 'DISASTER', 'HEALTH EMERGENCY']
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
