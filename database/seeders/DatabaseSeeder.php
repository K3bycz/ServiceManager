<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Device;
use App\Models\Repair;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(RepairStatusSeeder::class);
        
        $faker = Faker::create();

        $clients = [];
        for ($i = 0; $i < 10; $i++) {
            $clients[] = Client::create([
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'phoneNumber' => $faker->numerify('#########'),
            ]);
        }

        $devices = [];
        foreach ($clients as $client) {
            $devices[] = Device::create([
                'client_id' => $client->id,
                'category' => $faker->randomElement(['Laptop', 'Komputer Stacjonarny']),
                'manufacturer' => $faker->randomElement(['Dell', 'HP', 'Acer', 'Asus', 'Lenovo', 'Samsung']),
                'model' => $faker->bothify('???##?###??'),
                'serialNumber' => $faker->bothify('???######??'),
            ]);
        }

        foreach ($devices as $device) {
            $costs = $faker->randomFloat(2, 100, 500);
            $revenue = $faker->randomFloat(2, 150, 1200);
            $profit = $revenue - $costs; // Obliczenie profitu

            Repair::create([
                'device_id' => $device->id,
                'title' => $faker->sentence(3),
                'description' => $faker->sentence(6),
                'costs' => $costs,
                'revenue' => $revenue,
                'profit' => $profit,
                'status_id' => $faker->numberBetween(1, 7),
                'date_received' => $faker->dateTimeBetween('-30 days', 'now'),
                'date_released' => $faker->optional()->dateTimeBetween('-15 days', 'now'),
            ]);
        }
    }
}
