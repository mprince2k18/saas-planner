<?php

namespace Mprince2k18\SaasPlanner\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mprince2k18\SaasPlanner\SaasPlanner
 */
class SaasPlanner extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mprince2k18\SaasPlanner\SaasPlanner::class;
    }
}
