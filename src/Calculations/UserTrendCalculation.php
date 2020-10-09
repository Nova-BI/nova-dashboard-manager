<?php

namespace NovaBi\NovaDashboardManager\Calculations;

use App\User;

class UserTrendCalculation extends BaseTrendCalculation
{

    /**
     * Create a new base calculation.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        return (new User())->newQuery();
    }

}