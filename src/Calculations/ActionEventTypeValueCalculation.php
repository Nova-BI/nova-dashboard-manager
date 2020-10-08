<?php


namespace NovaBi\NovaDashboardManager\Calculations;

use Laravel\Nova\Actions\ActionEvent;

class ActionEventTypeValueCalculation extends BaseValueCalculation
{

    /**
     * Create a new base calculation.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        return (new ActionEvent())->newQuery()
            ->selectRaw('actionable_type, count(*) as count')
            ->groupBy('actionable_type')
            ->havingRaw('actionable_type is not Null');

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
}