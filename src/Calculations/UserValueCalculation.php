<?php

namespace NovaBi\NovaDashboardManager\Calculations;

class UserValueCalculation extends BaseValueCalculation
{

    /**
     * Create a new base calculation.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        return resolve(config('nova-dashboard.user_model'))->newQuery();
    }

    /*
     * Calculations
     *
     *
     */

    /*
     * Total number of users
     *
     */
    public function totalQuery()
    {
        return $this->newQuery();
    }


    /*
     * Total number of verified users
     *
     */
    public function verified()
    {
        $this->query = $this->query()->whereNotNull('email_verified_at');
        return $this;
    }
}
