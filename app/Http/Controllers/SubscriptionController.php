<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidTransitionException;
use App\Http\Resources\SubscriptionResource;
use App\States\PhaseState;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Services\SubscriptionService;
use Spatie\ModelStates\Exceptions\TransitionNotFound;
use Spatie\ModelStates\Validation\ValidStateRule;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    public function transitionToNextPhase(Request $request, Subscription $subscription): JsonResponse
    {
        $data = $request->validate([
            'phase' => new ValidStateRule(PhaseState::class),
        ]);

        try {
            $subscription->phase->transitionTo($data['phase']);
        } catch (TransitionNotFound $th) {
            throw new InvalidTransitionException();
        }

        return $this->successResource(new SubscriptionResource($subscription));
    }

    public function calculateProRatedAmount(Request $request, Subscription $subscription, SubscriptionService $service): JsonResponse
    {
        $data = $request->validate([
            'usedUntil' => 'required|date_format:Y-m-d',
        ]);

        return $this->successResponse(['amount' => $service->calculateUsageAmount($subscription, $data['usedUntil'])]);
    }
}
