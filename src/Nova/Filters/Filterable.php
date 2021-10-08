<?php

namespace NovaBi\NovaDashboardManager\Nova\Filters;

use Illuminate\Support\Carbon;

trait Filterable
{

    var $filterableId;

    public function setId($id) {
        $this->filterableId = $id;
        return $this;
    }

    public function getFilterableItem() {
        return self::$model::find($this->filterableId);
    }


    // to support multiple filters of same class
    // override the key function (returns class) to make the filterKey unique
    /*
     * in NovaFilter make the name independent from filter class
     *
        public function name()
        {
            $item = $this->getFilterableItem();
            return $item->filterParent->name; // support not unique filter names: . ' - '. $this->filterableId;
        }
     *
     */

    // usage in datametricables like this:
    /*
     *
     *  // iterate through all Filters of type <myFilterableClass>
        $this->dashboard()->datafilters()->whereFilterableType('<myFilterableClass>')->each(function ($filter) {
            // use $value to filter your data
           $value = $this->filters->getFilterValue(<myNovaFilterClass>, $filter->name);
        });
     *
     */

    function key()
    {
        return parent::key() . '-' . $this->filterableId;
    }

    public function default()
    {
        return $this->meta['default'];
    }


    public function rangeOptions() {
        return [
            'All' => 'ALL',
            '30 Days' => 30,
            '60 Days' => 60,
            '365 Days' => 365,
            'Today' => 'TODAY',
            'Month To Date' => 'MTD',
            'Quarter To Date' => 'QTD',
            'Year To Date' => 'YTD',
        ];
    }


    // copied from \Laravel\Nova\Metrics\Value::currentRange

    /**
     * Calculate the current range and calculate any short-cuts.
     *
     * @param string|int $range
     * @param string $timezone
     * @return array
     */
    protected function currentRange($range, $timezone)
    {
        if ($range == 'TODAY') {
            return [
                now($timezone)->today(),
                now($timezone),
            ];
        }

        if ($range == 'MTD') {
            return [
                now($timezone)->firstOfMonth(),
                now($timezone),
            ];
        }

        if ($range == 'QTD') {
            return $this->currentQuarterRange($timezone);
        }

        if ($range == 'YTD') {
            return [
                now($timezone)->firstOfYear(),
                now($timezone),
            ];
        }

        if ($range == 'ALL') {
            return [
                Carbon::createFromTimestamp(0),
                now($timezone),
            ];
        }

        return [
            now($timezone)->subDays($range),
            now($timezone),
        ];
    }

    /**
     * Calculate the previous quarter range.
     *
     * @param string $timezone
     *
     * @return array
     */
    protected function currentQuarterRange($timezone)
    {
        return [
            Carbon::firstDayOfQuarter($timezone),
            now($timezone),
        ];
    }


    /**
     * Calculate the previous range and calculate any short-cuts.
     *
     * @param string|int $range
     * @param string $timezone
     * @return array
     */
    protected function previousRange($range, $timezone)
    {
        if ($range == 'TODAY') {
            return [
                now($timezone)->modify('yesterday')->setTime(0, 0),
                now($timezone)->subDays(1),
            ];
        }

        if ($range == 'MTD') {
            return [
                now($timezone)->modify('first day of previous month')->setTime(0, 0),
                now($timezone)->subMonthsNoOverflow(1),
            ];
        }

        if ($range == 'QTD') {
            return $this->previousQuarterRange($timezone);
        }

        if ($range == 'YTD') {
            return [
                now($timezone)->subYears(1)->firstOfYear()->setTime(0, 0),
                now($timezone)->subYearsNoOverflow(1),
            ];
        }

        if ($range == 'ALL') {
            return [
                Carbon::createFromTimestamp(0),
                now($timezone),
            ];
        }

        return [
            now($timezone)->subDays($range * 2),
            now($timezone)->subDays($range),
        ];
    }

    /**
     * Calculate the previous quarter range.
     *
     * @param string $timezone
     *
     * @return array
     */
    protected function previousQuarterRange($timezone)
    {
        return [
            Carbon::firstDayOfPreviousQuarter($timezone)->setTimezone($timezone)->setTime(0, 0),
            now($timezone)->subMonthsNoOverflow(3),
        ];
    }

}
