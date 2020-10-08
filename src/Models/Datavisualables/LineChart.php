<?php

namespace NovaBi\NovaDashboardManager\Models\Datavisualables;

class LineChart extends BaseDatavisualable
{
    // mapping to visual
    var $visual = \NovaBi\NovaDashboardManager\Models\Datavisualables\Visuals\LineChart::class;


    public static function getResourceModel() {
        return \NovaBi\NovaDashboardManager\Nova\Datavisualables\LineChart::class;
    }


}
