<?php

namespace NovaBi\NovaDashboardManager\Calculations;



use Laravel\Nova\Actions\ActionEvent;

class ActionEventTrendCalculation extends BaseTrendCalculation
{

    /**
     * Create a new base calculation.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        return (new ActionEvent())->newQuery();
    }

}