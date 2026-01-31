<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RingaDataOutcomeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::middleware(['auth'])->group(function () {
    Route::post('/ringa-data/{id}/outcome', [RingaDataOutcomeController::class, 'store']);
});
