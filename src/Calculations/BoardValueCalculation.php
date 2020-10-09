<?php


namespace NovaBi\NovaDashboardManager\Calculations;


use NovaBi\NovaDashboardManager\Models\Dashboard;

class BoardValueCalculation extends BaseValueCalculation
{

    /**
     * Create a new base calculation.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        return (new Dashboard())->newQuery();
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