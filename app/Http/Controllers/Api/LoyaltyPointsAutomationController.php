<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyPointsAutomation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class LoyaltyPointsAutomationController extends Controller
{
    public function index()
    {
        $loyaltyPointsAutomation = LoyaltyPointsAutomation::query()->where('is_done', false)->oldest('id')->first();
        $url = null;

        if ($loyaltyPointsAutomation !== null) {
            $day = $loyaltyPointsAutomation->day->format('d-m-Y');
            $page = $loyaltyPointsAutomation->page + 1;
            $url = 'https://s.salla.sa/customers?' . http_build_query(['groups[]' => 83008794, 'created_after' => $day, 'created_before' => $day, 'page' => $page]);
        }

        return response()->json([
            'url' => $url,
        ]);
    }

    public function update(Request $request)
    {
        $isDone = $request->boolean('is_done');
        LoyaltyPointsAutomation::query()->where('day', $request->input('day'))->update([
            'page' => $isDone ? $request->input('page') : $request->input('page') + 1,
            'is_done' => $isDone,
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

    public function all()
    {
        return LoyaltyPointsAutomation::query()->oldest('id')->get();
    }
}
