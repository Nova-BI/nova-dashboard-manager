<?php

namespace NovaBi\NovaDashboardManager\Calculations;



use Laravel\Nova\Actions\ActionEvent;

class ActionEventTypeTrendCalculation extends BaseTrendCalculation
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

}