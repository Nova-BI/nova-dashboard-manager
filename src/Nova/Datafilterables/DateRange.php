<?php

namespace NovaBi\NovaDashboardManager\Nova\Datafilterables;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;

use NovaBi\NovaDashboardManager\Nova\Filters\Filterable;

class DateRange extends BaseFilter
{

    use Filterable;

    /**
     * The model the resource corresponds to.
     *
     * @var  string
     */
    public static $model = \NovaBi\NovaDashboardManager\Models\Datafilterables\DateRange::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return  array
     */
    public function filterFields(Request $request)
    {
        return [
            Select::make(__('Default Range'), 'DefaultValue')->options(array_flip($this->rangeOptions())),
        ];
    }
}
