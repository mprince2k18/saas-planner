<?php

use Mprince2k18\SaasPlanner\Models\Plan;
use Mprince2k18\SaasPlanner\Models\PlanFeature;

$factory->define(PlanFeature::class, function (Faker\Generator $faker) {
    return [
        'plan_id' => factory(Plan::class)->create()->id,
        'code' => $faker->word,
        'value' => $faker->randomElement(['10', '20', '30', '50', 'Y', 'N', 'UNLIMITED']),
    ];
});
