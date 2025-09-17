<?php

namespace App\Services;

use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionService
{
    public function calculateUsageAmount(Subscription $subscription, string $usedUntil): float
    {
        $usedUntil = Carbon::parse($usedUntil);

        $totalDuration = $subscription->start_date->diffInSeconds($subscription->end_date);
        $usedDuration  = $subscription->start_date->diffInSeconds($usedUntil);

        $precentageUsed = min(100, max(0, ($usedDuration / $totalDuration) * 100));

        return round((intval($precentageUsed) / 100) * $subscription->price, 2);
    }
}
