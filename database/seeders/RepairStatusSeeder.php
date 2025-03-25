<?php

namespace Database\Seeders;

use App\Models\RepairStatus;
use Illuminate\Database\Seeder;

class RepairStatusSeeder extends Seeder
{
    public function run()
    {
        RepairStatus::create([
            'name' => 'Nowa',
            'text_color' => '#FFFFFF',
            'background_color' => '#cc1635'
        ]);

        RepairStatus::create([
            'name' => 'W trakcie realizacji',
            'text_color' => '#FFFFFF',
            'background_color' => '#75aae6'
        ]);

        RepairStatus::create([
            'name' => 'Gotowa do wydania',
            'text_color' => '#FFFFFF',
            'background_color' => '#3db337'
        ]);

        RepairStatus::create([
            'name' => 'Zakończona',
            'text_color' => '#FFFFFF',
            'background_color' => '#0e7309'
        ]);

        RepairStatus::create([
            'name' => 'Oczekuje na części',
            'text_color' => '#FFFFFF',
            'background_color' => '#e3ae1e'
        ]);

        RepairStatus::create([
            'name' => 'Oczekuje na klienta',
            'text_color' => '#FFFFFF',
            'background_color' => '#e3ae1e'
        ]);

        RepairStatus::create([
            'name' => 'Na serwisie zewnętrznym',
            'text_color' => '#FFFFFF',
            'background_color' => '#a1a1a1'
        ]);
    }
}

