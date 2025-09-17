<?php

namespace App\Console\Commands;

use App\States\Trial;
use App\Models\Subscription;
use App\States\Active;
use Illuminate\Console\Command;

class ActivateTrialSubscriptions extends Command
{
    protected $signature = 'activate-trial-subscriptions';

    protected $description = 'Activate subscriptions whose trial ended';

    public function handle(): void
    {
        $subscriptions = Subscription::whereState('phase', Trial::class)
            ->where('end_date', '<=', now())
            ->get();

        foreach ($subscriptions as $subscription) {
            $subscription->phase->transitionTo(Active::class);
        }
    }
}
