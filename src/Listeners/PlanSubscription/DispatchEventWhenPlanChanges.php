<?php

namespace Mprince2k18\SaasPlanner\Listeners\PlanSubscription;

use Mprince2k18\SaasPlanner\Events\SubscriptionPlanChanged;
use Mprince2k18\SaasPlanner\Events\SubscriptionSaving;

class DispatchEventWhenPlanChanges
{
    /**
     * Handle event.
     *
     * @return void
     */
    public function handle(SubscriptionSaving $event)
    {
        $planId = $event->subscription->getOriginal('plan_id');

        // check if there is a plan and it is changed
        if ($planId && $planId !== $event->subscription->plan_id) {
            event(new SubscriptionPlanChanged($event->subscription));
        }
    }
}
