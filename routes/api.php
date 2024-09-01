<?php


use App\Http\Controllers\Api\LoyaltyPointsAutomationController;
use App\Models\Code;
use App\Models\Data;
use App\Models\Email;
use App\Models\Player;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::any('safwat-aljawf.com/rating/dashboard/clear', function (Request $request) {
    Rating::where('id', '!=', 99999999999999999)->delete();
});

Route::any('abaya/rating/store', function (Request $request) {
    //    $request->validate([
    //        'type'  => 'required',
    //        'stars' => 'required'
    //    ]);
    //
    Rating::create([
        'type'  => $request->input('rating_type'),
        'stars' => $request->stars,
    ]);

});


Route::get('true', function (Request $request) {
    return response()->json([
        'success' => true,

    ]);

});


Route::get('code', function (Request $request) {
    $player = Player::inRandomOrder()->first();
    $code = Code::where('redeemed', 0)->inRandomOrder()->first();
    $email = Email::where('blocked_to', '<', now())->inRandomOrder()->first();

    if (blank($code)) {
        return response()->json([
            'success' => false,

        ]);
    }

    return response()->json([
        'success'   => true,
        'player_id' => '533038203', // $player->player_id,
        'code'      => removeSpecialCharacters($code->code),
        'email'     => $email->username,
        'password'  => $email->password,
        'code_id'   => 0,
    ]);
});


Route::post('block-email', function (Request $request) {
    if ($request->has('email')) {
        Email::where('username', $request->input('email'))->update([
            'blocked_to' => now()->addHour(),
        ]);
    }

});

Route::post('redeem-code', function (Request $request) {
    if ($request->has('code')) {
        Code::where('code', $request->input('code'))->update([
            'redeemed' => 1,
        ]);
        Email::where('username', $request->input('email'))->update([
            'blocked_to' => now()->addMinutes(15),
        ]);
    }

});

Route::prefix('loyalty-points-automation')->group(function () {
    Route::get('/', [LoyaltyPointsAutomationController::class, 'index']);
    Route::put('/', [LoyaltyPointsAutomationController::class, 'update']);
    Route::get('fresh', [LoyaltyPointsAutomationController::class, 'fresh']);
    Route::get('seed', [LoyaltyPointsAutomationController::class, 'seed']);
    Route::get('all', [LoyaltyPointsAutomationController::class, 'all']);
    Route::get('reset', [LoyaltyPointsAutomationController::class, 'reset']);
});

Route::post('test-python', function (Request $request) {
    Email::create([
        'username'   => $request->input('email'),
        'password'   => $request->input('password'),
        'blocked_to' => now()->subDay(),
    ]);

    return response()->json([
        'success' => true,
    ]);
});

Route::get('top2cards-fetch-non-stc-order', function (Request $request) {
    return response()->json([
        'success' => false,
    ]);
});

Route::get('top2cards-fetch-stc-order', function (Request $request) {
    return response()->json([
        'success' => true,
    ]);
});


Route::any('any', function (Request $request) {

    \Log::error($request->all());

    return response()->json([
        'success' => false,
    ]);

});


Route::any('/pull-nava-images', function () {
    \Log::error(\request()->all());

    $data = Data::select('salla_id', 'data')->get();

    return response()->json($data, 200);
});


Route::any('salla-api-example', function (Request $request) {
    $ids = [];
    foreach (range(1, 15000) as $id) {
        $ids[] = $id;
    }


    return response()->json([
        "status"     => 200,
        "success"    => true,
        "data"       => [
            'ids' => $ids,

        ],
        "pagination" => [
            "count"       => 1,
            "total"       => 1800,
            "perPage"     => 15,
            "currentPage" => 1,
            "totalPages"  => 1,
            "links"       => [],
        ],
    ]);
});


