<?php

namespace Mprince2k18\SaasPlanner\Contracts;

interface PlanInterface
{
    public function features();

    public function subscriptions();

    public function isFree();

    public function hasTrial();
}
