<?php

namespace NovaBi\NovaDashboardManager\Nova\Datametricables;

use DigitalCreative\InlineMorphTo\HasInlineMorphToFields;
use Illuminate\Http\Request;

use Laravel\Nova\Fields\Text;

class actionEvents extends BaseMetric
{
    use HasInlineMorphToFields;

    /**
     * @var int sort order of morphables
     */
    public static $sort_order = 4;

    /**
     * The model the resource corresponds to.
     *
     * @var  string
     */
    public static $model = \NovaBi\NovaDashboardManager\Models\Datametricables\actionEvents::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return  array
     */
    public function metricFields(Request $request)
    {
        return [
//            Text::make(__('my Action Events Metric Option'), 'action_events_metric_option'),
        ];
    }
}
