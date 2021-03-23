<?php

namespace NovaBi\NovaDashboardManager\Models\Datavisualables;

class BarChart extends BaseDatavisualable
{
    // mapping to visual
    public string $visual = Visuals\BarChart::class;


    public static function getResourceModel() {
        return \NovaBi\NovaDashboardManager\Nova\Datavisualables\BarChart::class;
    }


}
