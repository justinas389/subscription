<?php

namespace App\Http\Controllers;

use App\States\PhaseState;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Services\SubscriptionService;
use Spatie\ModelStates\Exceptions\TransitionNotFound;
use Spatie\ModelStates\Validation\ValidStateRule;

class SubscriptionController extends Controller
{
    public function transitionToNextPhase(Request $request, Subscription $subscription)
    {
        $data = $request->validate([
            'phase' => new ValidStateRule(PhaseState::class),
        ]);

        try {
            $subscription->phase->transitionTo($data['phase'])->toResource();
        } catch (TransitionNotFound $th) {
            abort(422, 'Invalid phase transition');
        }

        return $subscription;
    }

    public function calculateProRatedAmount(Request $request, Subscription $subscription, SubscriptionService $service)
    {
        $data = $request->validate([
            'usedUntil' => 'required|date_format:Y-m-d',
        ]);

        return ['amount' => $service->calculateUsageAmount($subscription, $data['usedUntil'])];
    }
}
