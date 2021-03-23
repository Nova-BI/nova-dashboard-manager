<?php

namespace NovaBi\NovaDashboardManager\Models\Datavisualables;

class LineChart extends BaseDatavisualable
{
    // mapping to visual
    public string $visual = Visuals\LineChart::class;


    public static function getResourceModel() {
        return \NovaBi\NovaDashboardManager\Nova\Datavisualables\LineChart::class;
    }


}