<?php

use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post(
        'subscriptions/{subscription}/transition',
        [SubscriptionController::class, 'transitionToNextPhase']
    )->name('subscriptions.transition');

    Route::get(
        'subscriptions/{subscription}/amount',
        [SubscriptionController::class, 'calculateProRatedAmount']
    )->name('subscriptions.amount');
});
