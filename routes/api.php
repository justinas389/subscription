<?php

use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('subscriptions/{subscription}/transition', [SubscriptionController::class, 'transitionToNextPhase'])->name('subscriptions.transition');
    Route::get('subscriptions/{subscription}/amount', [SubscriptionController::class, 'calculateProRatedAmount'])->name('subscriptions.amount');
    Route::get('subscriptions', [SubscriptionController::class, 'index']);
});
