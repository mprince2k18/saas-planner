<?php

namespace Mprince2k18\SaasPlanner\Models;

use Illuminate\Database\Eloquent\Model;
use Mprince2k18\SaasPlanner\Contracts\PlanInterface;
use Mprince2k18\SaasPlanner\Exceptions\InvalidPlanFeatureException;
use Mprince2k18\SaasPlanner\Period;

class Plan extends Model implements PlanInterface
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'interval',
        'interval_count',
        'trial_period_days',
        'sort_order',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at',
    ];

    /**
     * Boot function for using with User Events.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (! $model->interval) {
                $model->interval = 'month';
            }

            if (! $model->interval_count) {
                $model->interval_count = 1;
            }
        });
    }

    /**
     * Get plan features.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function features()
    {
        return $this->hasMany(config('saas-planner.models.plan_feature'));
    }

    /**
     * Get plan subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(config('saas-planner.models.plan_subscription'));
    }

    /**
     * Get Interval Name
     *
     * @return mixed string|null
     */
    public function getIntervalNameAttribute()
    {
        $intervals = Period::getAllIntervals();

        return isset($intervals[$this->interval]) ? $intervals[$this->interval] : null;
    }

    /**
     * Get Interval Description
     *
     * @return string
     */
    public function getIntervalDescriptionAttribute()
    {
        return trans_choice('saas-planner::messages.interval_description.'.$this->interval, $this->interval_count);
    }

    /**
     * Check if plan is free.
     *
     * @return bool
     */
    public function isFree()
    {
        return (float) $this->price <= 0.00;
    }

    /**
     * Check if plan has trial.
     *
     * @return bool
     */
    public function hasTrial()
    {
        return is_numeric($this->trial_period_days) and $this->trial_period_days > 0;
    }

    /**
     * Returns the demanded feature
     *
     * @param  string  $code
     * @return PlanFeature
     *
     * @throws InvalidPlanFeatureException
     */
    public function getFeatureByCode($code)
    {
        $feature = $this->features()->getEager()->first(function ($item) use ($code) {
            return $item->code === $code;
        });

        if (is_null($feature)) {
            throw new InvalidPlanFeatureException($code);
        }

        return $feature;
    }
}
