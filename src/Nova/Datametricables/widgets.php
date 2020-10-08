<?php

namespace NovaBi\NovaDashboardManager\Nova\Datametricables;

use DigitalCreative\InlineMorphTo\HasInlineMorphToFields;
use Illuminate\Http\Request;

use Laravel\Nova\Fields\Text;

class widgets extends BaseMetric
{
    use HasInlineMorphToFields;

    /**
     * @var int sort order of morphables
     */
    public static $sort_order = 3;

    /**
     * The model the resource corresponds to.
     *
     * @var  string
     */
    public static $model = \NovaBi\NovaDashboardManager\Models\Datametricables\widgets::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return  array
     */
    public function metricFields(Request $request)
    {
        return [];
    }
}
