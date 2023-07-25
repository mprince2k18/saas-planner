<?php

namespace Mprince2k18\SaasPlanner\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mprince2k18\SaasPlanner\SaasPlannerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Mprince2k18\\SaasPlanner\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            SaasPlannerServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_saas-planner_table.php.stub';
        $migration->up();
        */
    }
}
