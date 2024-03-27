<?php

namespace Database\Seeders;

use App\Models\LoyaltyPointsAutomation;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class LoyaltyPointsAutomationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $period = CarbonPeriod::create('2023-12-21', '2024-03-25');
        foreach ($period as $date) {
            LoyaltyPointsAutomation::query()->firstOrCreate([
                'day' => $date,
            ]);
        }
    }
}
