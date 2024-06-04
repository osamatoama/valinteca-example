<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyPointsAutomation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;

class LoyaltyPointsAutomationController extends Controller
{
    public function index()
    {
        $loyaltyPointsAutomation = LoyaltyPointsAutomation::query()
            ->where('is_done', false)
            ->where('should_pass', false)
            ->where('day', '<=', now()->subDays(4))
            ->oldest('id')
            ->first();
        $url = null;

        if ($loyaltyPointsAutomation !== null) {
            $day = $loyaltyPointsAutomation->day->format('d-m-Y');
            $page = $loyaltyPointsAutomation->page + 1;
            $url = 'https://s.salla.sa/customers?' . http_build_query(['created_after' => $day, 'created_before' => $day, 'page' => $page]);
        }

        return response()->json([
            'url' => $url,
        ]);
    }

    public function update(Request $request)
    {
        LoyaltyPointsAutomation::query()->where('day', Carbon::parse($request->input('day')))->update([
            'page' => $request->input('page'),
            'is_done' => $request->boolean('is_done'),
        ]);

        return response()->noContent();
    }

    public function fresh()
    {
        LoyaltyPointsAutomation::query()->truncate();
        Artisan::call('db:seed', ['--class' => 'LoyaltyPointsAutomationSeeder']);

        return response()->json([
            'message' => Artisan::output(),
        ]);
    }

    public function seed()
    {
        Artisan::call('db:seed', ['--class' => 'LoyaltyPointsAutomationSeeder']);

        return response()->json([
            'message' => Artisan::output(),
        ]);
    }

    public function all()
    {
        return LoyaltyPointsAutomation::query()->oldest('id')->get();
    }

    public function reset()
    {
        LoyaltyPointsAutomation::query()->where('should_pass', false)->update([
            'page' => 0,
            'is_done' => false,
        ]);

        return response()->json([
            'message' => 'Done',
        ]);
    }
}
