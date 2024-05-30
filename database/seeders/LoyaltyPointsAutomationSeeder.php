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
        $period = CarbonPeriod::create('2024-05-22', '2024-12-31');
        foreach ($period as $date) {
            LoyaltyPointsAutomation::query()->firstOrCreate([
                'day' => $date,
            ]);
        }
    }
}
