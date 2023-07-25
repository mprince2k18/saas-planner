<?php

namespace Mprince2k18\SaasPlanner\Listeners\PlanSubscription;

use Mprince2k18\SaasPlanner\Events\SubscriptionSaving;

class SetPeriodWhenEmpty
{
    /**
     * Handle event.
     *
     * @return void
     */
    public function handle(SubscriptionSaving $event)
    {
        // Set period if it wasn't set
        if (! $event->subscription->ends_at) {
            $event->subscription->setNewPeriod();
        }
    }
}
