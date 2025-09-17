<?php

use App\Models\User;
use App\States\Trial;
use App\States\Active;
use App\States\Canceled;
use App\States\Suspended;
use App\Models\Subscription;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user, ['*']);
});

it('transition successfully', function ($fromState, $toState) {
    $subscription = Subscription::factory()->create([
        'phase' => $fromState,
    ]);

    $response = $this->postJson(route('subscriptions.transition', $subscription), [
        'phase' => $toState,
    ]);

    $response->assertOk();

    expect($subscription->fresh()->phase->equals($toState))->toBeTrue();
})->with([
    [Active::class, Suspended::class],
    [Active::class, Canceled::class],
]);


it('transition fail', function ($fromState, $toState) {
    $subscription = Subscription::factory()->create([
        'phase' => $fromState,
    ]);

    $response = $this->postJson(route('subscriptions.transition', $subscription), [
        'phase' => $toState,
    ]);

    $response->assertStatus(422);

    expect($subscription->fresh()->phase->equals($fromState))->toBeTrue();
})->with([
    [Active::class, Trial::class],
]);

it('calculates prorated amount successfully', function () {
    $subscription = Subscription::factory()->create([
        'start_date' => now()->subDays(50),
        'end_date' => now()->addDays(50),
        'price' => 100,
    ]);

    $usedUntil = now()->addDays(1)->format('Y-m-d');

    $response = $this->getJson(route('subscriptions.amount', [
        'subscription' => $subscription->id,
        'usedUntil' => $usedUntil,
    ]));

    $response->assertOk()->assertExactJson([
        'data' => [
            'amount' => 50
        ]
    ]);
});

it('activates trial subscriptions whose end date has passed', function () {
    $pastTrial = Subscription::factory()->create([
        'phase' => Trial::class,
        'end_date' => now()->subDay(),
    ]);

    $futureTrial = Subscription::factory()->create([
        'phase' => Trial::class,
        'end_date' => now()->addDay(),
    ]);

    $this->artisan('activate-trial-subscriptions')->assertExitCode(0);
    
    expect($pastTrial->fresh()->phase->equals(Active::class))->toBeTrue();

    expect($futureTrial->fresh()->phase->equals(Trial::class))->toBeTrue();
});