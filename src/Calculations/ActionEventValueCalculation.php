<?php


namespace NovaBi\NovaDashboardManager\Calculations;


use Laravel\Nova\Actions\ActionEvent;

class ActionEventValueCalculation extends BaseValueCalculation
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