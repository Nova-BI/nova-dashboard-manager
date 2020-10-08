<?php

namespace NovaBi\NovaDashboardManager\Nova\Datafilterables;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Select;

class ActionEventTypes extends BaseFilter
{
    /**
     * The model the resource corresponds to.
     *
     * @var  string
     */
    public static $model = \NovaBi\NovaDashboardManager\Models\Datafilterables\ActionEventTypes::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return  array
     */
    public function filterFields(Request $request)
    {
        $filterClass = $this->getFilterClass();
        $eventTypes = (new $filterClass)->eventTypes();

        return [
            BooleanGroup::make(__('Pre-Selected Action Events'), 'DefaultValue')->options($eventTypes)->hideFalseValues(),
        ];
    }
}
