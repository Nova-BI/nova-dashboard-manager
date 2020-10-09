<?php


namespace NovaBi\NovaDashboardManager\Models\Datametricables;

use Cake\Chronos\Chronos;
use Carbon\Carbon;
use DigitalCreative\NovaDashboard\Filters;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Nova;
use NovaBi\NovaDashboardManager\Models\Datavisualables\Value;
use NovaBi\NovaDashboardManager\Models\Datawidget;
use NovaBi\NovaDashboardManager\Nova\Filters\DateRangeDefined;
use NovaBi\NovaDashboardManager\Traits\HasSchemalessAttributesTrait;
use Illuminate\Database\Eloquent\Model;


class BaseDatametricable extends Model
{
    use HasSchemalessAttributesTrait;

    public $timestamps = true;

    // supported visuals
    var $visualisationTypes = [];

    public $casts = [
        'extra_attributes' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(Str::singular(config('nova-dashboard-manager.tables.metrics')) . '_standard');
    }

    /**
     * @return string[]
     */
    public function getVisualisationTypes(): array
    {
        return $this->visualisationTypes;
    }


    public function datawidgets()
    {
        return $this->morphMany(Datawidget::class, 'metricable');
    }

    public function visualable()
    {
        return $this->morphTo();
    }


    public function calculate(Collection $options, Filters $filters)
    {

        return null;
    }


    public function formatTrendData($dateValue, Trend $calcuation)
    {
        $request = resolve(NovaRequest::class);
        $timezone = Nova::resolveUserTimezone($request) ?? $request->timezone;

        $nowChronos = Chronos::now();
        $nowCarbon = Carbon::now();

        // for custom date periods check
        // https://carbon.nesbot.com/docs/#api-period

        switch ($dateValue) {
            case 'TODAY':
                $request->range = $nowChronos->hour + 1; // hours today
                $result = $calcuation->countByHours($request, $calcuation->query(), 'created_at');
                $labels = array_keys($result->trend);
                break;
            case '_365':
                $request->range = 365;
                $result = $calcuation->countByDays($request, $calcuation->query(), 'created_at');
                $labels = array_keys($result->trend);
                break;
            case 'QTD':
                $request->range = $nowCarbon->firstOfQuarter()->diffInDays()+1;
                $result = $calcuation->countByDays($request, $calcuation->query(), 'created_at');
                $labels = array_keys($result->trend);
                break;
            case 'YTD':
                $request->range = $nowChronos->month;
                $result = $calcuation->countByMonths($request, $calcuation->query(), 'created_at');
                $labels = array_keys($result->trend);
                break;
            case '30':
            case '60':
            case '365':
            case 'MTD':
                $request->range = $dateValue;
                if ($dateValue == 'MTD') {
                    $request->range = $nowChronos->day;
                    $result = $calcuation->countByDays($request, $calcuation->query(), 'created_at');
                } else {
                    $request->range = $dateValue;
                    $result = $calcuation->countByDays($request, $calcuation->query(), 'created_at');
                }


                $labels_raw = array_keys($result->trend);
                $first = reset($labels_raw);
                $last = end($labels_raw);
                $labels = range(0, $request->range-1);

                // set all legend items empty
                array_walk($labels, function (&$item) {
                    $item = '';
                });

                $labels[0] = $first;
                $labels[sizeof($labels) - 1] = $last;
                break;
            case 'ALL':
            default:
                $request->range = 12;
                $result = $calcuation->countByMonths($request, $calcuation->query(), 'created_at');
                $labels = array_keys($result->trend);
                break;
        }


        $values = array_values($result->trend);

        return [
            'labels' => $labels,
            'values' => $values

        ];
    }

    public function previousDateRange($range, $timezone)
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

        return [
            now($timezone)->subDays($range * 2),
            now($timezone)->subDays($range),
        ];
    }

}
