<?php

namespace Mprince2k18\SaasPlanner\Contracts;

use Illuminate\Database\Eloquent\Model;

interface SubscriptionResolverInterface
{
    /**
     * Resolve the subscribable subscription.
     *
     * @param  string  $name The subscription name if your site supports multiple subscriptions.
     * @return Model
     */
    public function resolve(Model $subscribable, $name);
}
