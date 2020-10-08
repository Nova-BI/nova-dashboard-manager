<?php
namespace NovaBi\NovaDashboardManager\Nova\Filters;

use Ampeco\Filters\DateRangeFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class DateRangePicker extends DateRangeFilter
{

    public static $field = 'date_range_picker';

    /**
     * Get the displayable name of the filter.
     *
     * @return string
     */
    public function name()
    {
        return __('Date Range Picker');
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

        $from = Carbon::parse($value[0])->startOfDay();
        $to = Carbon::parse($value[1])->endOfDay();

        return $query->whereBetween('created_at', [$from, $to]);
    }

    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'field' => self::$field,
        ]);
    }
}
