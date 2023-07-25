<?php

namespace Mprince2k18\SaasPlanner;

use Illuminate\Support\Facades\Event;
use Mprince2k18\SaasPlanner\Commands\SaasPlannerCommand;
use Mprince2k18\SaasPlanner\Contracts\PlanFeatureInterface;
use Mprince2k18\SaasPlanner\Contracts\PlanInterface;
use Mprince2k18\SaasPlanner\Contracts\PlanSubscriptionInterface;
use Mprince2k18\SaasPlanner\Contracts\PlanSubscriptionUsageInterface;
use Mprince2k18\SaasPlanner\Contracts\SubscriptionBuilderInterface;
use Mprince2k18\SaasPlanner\Contracts\SubscriptionResolverInterface;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SaasPlannerServiceProvider extends PackageServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'saas-planner');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../config/saas-planner.php' => config_path('saas-planner.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../lang' => resource_path('lang/vendor/saas-planner'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/saas-planner.php', 'saas-planner');

        $this->app->bind(PlanInterface::class, config('saas-planner.models.plan'));
        $this->app->bind(PlanFeatureInterface::class, config('saas-planner.models.plan_feature'));
        $this->app->bind(PlanSubscriptionInterface::class, config('saas-planner.models.plan_subscription'));
        $this->app->bind(PlanSubscriptionUsageInterface::class, config('saas-planner.models.plan_subscription_usage'));
        $this->app->bind(SubscriptionBuilderInterface::class, SubscriptionBuilder::class);
        $this->app->bind(SubscriptionResolverInterface::class, SubscriptionResolver::class);

        Event::listen(
            \Mprince2k18\SaasPlanner\Events\SubscriptionSaving::class,
            \Mprince2k18\SaasPlanner\Listeners\PlanSubscription\SetPeriodWhenEmpty::class
        );

        Event::listen(
            \Mprince2k18\SaasPlanner\Events\SubscriptionSaving::class,
            \Mprince2k18\SaasPlanner\Listeners\PlanSubscription\DispatchEventWhenPlanChanges::class
        );
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('saas-planner')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_saas-planner_table')
            ->hasCommand(SaasPlannerCommand::class);
    }
}
