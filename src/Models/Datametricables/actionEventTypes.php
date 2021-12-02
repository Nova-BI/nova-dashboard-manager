<?php

namespace NovaBi\NovaDashboardManager\Models\Datametricables;


use DigitalCreative\NovaDashboard\Filters;
use Illuminate\Support\Collection;
use NovaBi\NovaDashboardManager\Calculations\ActionEventTypeTrendCalculation;
use NovaBi\NovaDashboardManager\Calculations\ActionEventTypeValueCalculation;
use Laravel\Nova\Actions\ActionEvent;
use NovaBi\NovaDashboardManager\Nova\Filters\DateRangeDefined;

class actionEventTypes extends BaseDatametricable
{
    /*
     * configure supported visualisationTypes
     * methode 'calculate' must return a valid calculation
     */

    public array $visualisationTypes = [
        'Value' => 'Number of Action Event Types',
        'LineChart' => 'Linechart-Trend of Action Event Types',
        'BarChart' => 'Barchart-Trend of Action Event Types'
    ];

    public static function getResourceModel()
    {
        return \NovaBi\NovaDashboardManager\Nova\Datametricables\actionEventTypes::class;
    }

    public function getActionEventsMetricOptionAttribute()
    {
        return $this->extra_attributes->action_events_metric;
    }

    public function setActionEventsMetricOptionAttribute($value)
    {
        $this->extra_attributes->action_events_metric = $value;
    }

    public function calculate(Collection $options, Filters $filters)
    {

        switch ($this->visualable_type) {
            case \NovaBi\NovaDashboardManager\Models\Datavisualables\Value::class:

                $calculation = ActionEventTypeValueCalculation::make();

                $calculationCurrentValue = (clone $calculation)
                    ->applyFilter(
                        $filters,
                        DateRangeDefined::class,
                        ['dateColumn' => 'created_at']
                    )
                    ->applyFilter($filters, \NovaBi\NovaDashboardManager\Nova\Filters\ActionEventType::class);


                $calculationPreviousValue = (clone $calculation)
                    ->applyFilter(
                        $filters,
                        DateRangeDefined::class,
                        ['dateColumn' => 'created_at', 'previousRange' => true]
                    )
                    ->applyFilter($filters, \NovaBi\NovaDashboardManager\Nova\Filters\ActionEventType::class);

                return [
                    'currentValue' => $calculationCurrentValue->query()->get()->count(),
                    'previousValue' => $calculationPreviousValue->query()->get()->count()
                ];


                break;

            case \NovaBi\NovaDashboardManager\Models\Datavisualables\LineChart::class:
            case \NovaBi\NovaDashboardManager\Models\Datavisualables\BarChart::class:

                // Using Nova Trend calculations
                $calculation = ActionEventTypeTrendCalculation::make();
                $calculation->applyFilter($filters, \NovaBi\NovaDashboardManager\Nova\Filters\ActionEventType::class);


                $dateValue = $filters->getFilterValue(DateRangeDefined::class);

                $eventTypes = (new ActionEvent())->newQuery()->select('actionable_type')->distinct()->get()->toArray();


                $dataset = [];
                $labels = null;

                //workaround - could be done in one query

                foreach ($eventTypes as $eventType) {
                    $typecalculation = (clone $calculation);
                    $typecalculation->query()->where('actionable_type', '=', $eventType['actionable_type']);

                    $data = $this->formatTrendData($dateValue, $typecalculation);

                    $dataset[$eventType['actionable_type']] = [
                        'name' => $eventType['actionable_type'],
                        'data' => $data['values']
                    ];
                    if (!$labels) {
                        $labels = $data['labels'];
                    }
                }

                return [
                    'labels' => $labels,
                    'datasets' => $dataset
                ];

                break;
        }
    }
}
