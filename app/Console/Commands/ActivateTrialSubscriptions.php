<?php

namespace App\Console\Commands;

use App\States\Trial;
use App\Models\Subscription;
use App\States\Active;
use Illuminate\Console\Command;

class ActivateTrialSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activate-trial-subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate subscriptions whose trial ended';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscriptions = Subscription::whereState('phase', Trial::class)
            ->where('end_date', '<=', now())
            ->get();

        foreach ($subscriptions as $subscription) {
            $subscription->phase->transitionTo(Active::class);
        }
    }
}
