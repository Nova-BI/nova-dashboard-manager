<?php

namespace NovaBi\NovaDashboardManager\Calculations;

class UserTrendCalculation extends BaseTrendCalculation
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

}
