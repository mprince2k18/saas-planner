<?php

namespace Mprince2k18\SaasPlanner\Events;

use Illuminate\Queue\SerializesModels;
use Mprince2k18\SaasPlanner\Models\PlanSubscription;

class SubscriptionRenewed
{
    use SerializesModels;

    /**
     * @var \Laraplans\Models\PlanSubscription
     */
    public $subscription;

    /**
     * Create a new event instance.
     *
     * @param  \Laraplans\Models\PlanSubscription  $subscription
     * @return void
     */
    public function __construct(PlanSubscription $subscription)
    {
        $this->subscription = $subscription;
    }
}
