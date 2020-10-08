<?php

namespace NovaBi\NovaDashboardManager\Nova\Datametricables;

use DigitalCreative\InlineMorphTo\HasInlineMorphToFields;
use Illuminate\Http\Request;

use Laravel\Nova\Fields\Boolean;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Epartment\NovaDependencyContainer\HasDependencies;
use Laravel\Nova\Fields\Text;

class users extends BaseMetric
{
    use HasInlineMorphToFields;
    use HasDependencies;

    /**
     * @var int sort order of morphables
     */
    public static $sort_order = 1;

    /**
     * The model the resource corresponds to.
     *
     * @var  string
     */
    public static $model = \NovaBi\NovaDashboardManager\Models\Datametricables\users::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return  array
     */
    public function metricFields(Request $request)
    {
        return [
            NovaDependencyContainer::make([
                Boolean::make(__('Only with verified email'), 'only_verified_email'),
            ])->dependsOn('visualable', \NovaBi\NovaDashboardManager\Nova\Datavisualables\Value::class),
        ];
    }
}
