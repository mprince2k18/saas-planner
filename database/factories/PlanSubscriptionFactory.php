<?php

use Mprince2k18\SaasPlanner\Models\Plan;
use Mprince2k18\SaasPlanner\Models\PlanSubscription;
use Mprince2k18\SaasPlanner\Tests\Models\User;

$factory->define(PlanSubscription::class, function (Faker\Generator $faker) {
    return [
        'subscribable_id' => factory(User::class)->create()->id,
        'subscribable_type' => User::class,
        'plan_id' => factory(Plan::class)->create()->id,
        'name' => $faker->word,
    ];
});
