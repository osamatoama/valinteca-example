<?php


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

