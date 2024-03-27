<?php


use App\Http\Controllers\Api\LoyaltyPointsAutomationController;
use App\Models\Code;
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
        'type' => $request->input('rating_type'),
        'stars' => $request->stars,
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
        'success' => true,
        'player_id' => $player->player_id,
        'code' => $code->code,
        'email' => $email->username,
        'password' => $email->password,
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
    Route::get('all', [LoyaltyPointsAutomationController::class, 'all']);
});
