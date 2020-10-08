<?php

namespace NovaBi\NovaDashboardManager\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Actions\ActionEvent;
use Laravel\Nova\Filters\BooleanFilter;
use Illuminate\Support\Arr;

class ActionEventType extends BooleanFilter
{

    use Filterable;

    /**
     * Apply the filter to the given query.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        if ($query->getModel()->getTable() == (new ActionEvent)->getTable()) {

            $filteredValues = Arr::where($value, function ($value, $key) {
                if ($value) {
                    return $key;
                }
            });
            if (sizeof($filteredValues) > 0) {
                $query = $query->whereIn('actionable_type', array_keys($filteredValues));
            }

        }
        return $query;

        /*
         * the long way...
        $eventTypes = $this->eventTypes();
        foreach ($eventTypes as $eventType => $v) {
            if (array_key_exists($eventType, $value)) {
                $query = $query->orWhere('actionable_type', $eventType);
            }
        }
        return $query;
        */

    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return $this->eventTypes();
    }

    public function eventTypes()
    {
        $actionEventTypes = ActionEvent::select('actionable_type')->distinct()->get();
        $actionEventTypes = $actionEventTypes->groupBy('actionable_type')->keys()->all();

        // set keys and values
        $actionEventTypesFull = array_combine($actionEventTypes, $actionEventTypes);
        return $actionEventTypesFull;

    }
}
