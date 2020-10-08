<?php

namespace NovaBi\NovaDashboardManager\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\DateFilter;
use Laravel\Nova\Nova;

class DateRangeDefined extends DateFilter
{
    
    use Filterable;

    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Get the displayable name of the filter.
     *
     * @return string
     */
    public function name()
    {
        return __('Date Range');
    }

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
        $timezone = Nova::resolveUserTimezone($request) ?? $request->timezone;

        $dateColumn = $query->getModel()->getCreatedAtColumn();
        if (isset($this->meta()['dateColumn'])) {
            $dateColumn = $this->meta()['dateColumn'] ?: $dateColumn;
        }
        if (isset($this->meta()['previousRange'])) {
            if ($this->meta()['previousRange'] == true) {
                return $query->whereBetween($dateColumn, $this->previousRange($value, $timezone));
            }
        }
        return $query->whereBetween($dateColumn, $this->currentRange($value, $timezone));
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return $this->rangeOptions();
    }

}
