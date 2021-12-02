<?php

namespace NovaBi\NovaDashboardManager\Models\Datametricables;

use DigitalCreative\NovaDashboard\Filters;
use Illuminate\Support\Collection;
use NovaBi\NovaDashboardManager\Calculations\BoardValueCalculation;
use NovaBi\NovaDashboardManager\Calculations\BoardTrendCalculation;
use NovaBi\NovaDashboardManager\Models\Dashboard;
use Illuminate\Http\Request;
use NovaBi\NovaDashboardManager\Nova\Filters\DateRangeDefined;

class boards extends BaseDatametricable
{
    /*
     * configure supported visualisationTypes
     * methode 'calculate' must return a valid calculation
     */

    public array $visualisationTypes = [
        'Value' => 'Number of Boards',
        'LineChart' => 'Linechart-Trend of Boards',
        'BarChart' => 'Barchart-Trend of Boards'
    ];

    public static function getResourceModel()
    {
        return \NovaBi\NovaDashboardManager\Nova\Datametricables\boards::class;
    }

    /**
     * // example custom attributes
    public function getBoardsMetricOptionAttribute()
    {
        return $this->extra_attributes->boards_metric_option;
    }


    public function setBoardsMetricOptionAttribute($value)
    {
        $this->extra_attributes->boards_metric_option = $value;
    }

     */

    public function calculate(Collection $options, Filters $filters)
    {

        switch ($this->visualable_type) {
            case \NovaBi\NovaDashboardManager\Models\Datavisualables\Value::class:

                $calculation = BoardValueCalculation::make();

                $calculationCurrentValue = (clone $calculation)->applyFilter(
                    $filters,
                    DateRangeDefined::class,
                    ['dateColumn' => 'created_at']
                );

                $calculationPreviousValue = (clone $calculation)->applyFilter(
                    $filters,
                    DateRangeDefined::class,
                    ['dateColumn' => 'created_at', 'previousRange' => true]
                );

                return [
                    'currentValue' => $calculationCurrentValue->query()->get()->count(),
                    'previousValue' => $calculationPreviousValue->query()->get()->count()
                ];


                break;

            case \NovaBi\NovaDashboardManager\Models\Datavisualables\LineChart::class:
            case \NovaBi\NovaDashboardManager\Models\Datavisualables\BarChart::class:

                // Using Nova Trend calculations
                $calculation = BoardTrendCalculation::make();

                $dateValue = $filters->getFilterValue(DateRangeDefined::class);

                $result = $this->formatTrendData($dateValue, $calculation);


                return [
                    'labels' => $result['labels'],
                    'datasets' => [
                        'Boards' => [
                            'name' => 'Boards',
                            'data' => $result['values'],
                            'options' => []
                        ]
                    ]
                ];
                break;
        }
    }
}
