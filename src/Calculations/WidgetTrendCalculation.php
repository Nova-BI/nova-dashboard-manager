<?php

namespace NovaBi\NovaDashboardManager\Calculations;

use NovaBi\NovaDashboardManager\Models\Datawidget;

class WidgetTrendCalculation extends BaseTrendCalculation
{

    /**
     * Create a new base calculation.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        return (new Datawidget())->newQuery();
    }

}