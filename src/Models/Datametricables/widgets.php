<?php

namespace NovaBi\NovaDashboardManager\Models\Datametricables;

use DigitalCreative\NovaDashboard\Filters;
use Illuminate\Support\Collection;
use NovaBi\NovaDashboardManager\Calculations\WidgetTrendCalculation;
use NovaBi\NovaDashboardManager\Calculations\WidgetValueCalculation;
use NovaBi\NovaDashboardManager\Models\Dashboard;
use Illuminate\Http\Request;
use NovaBi\NovaDashboardManager\Nova\Filters\DateRangeDefined;

class widgets extends BaseDatametricable
{
    /*
     * configure supported visualisationTypes
     * methode 'calculate' must return a valid calculation
     */

    public array $visualisationTypes = [
        'Value' => 'Number of Widgets',
        'LineChart' => 'Linechart-Trend of Widgets',
        'BarChart' => 'Barchart-Trend of Widgets'
    ];

    public static function getResourceModel()
    {
        return \NovaBi\NovaDashboardManager\Nova\Datametricables\widgets::class;
    }


    public function calculate(Collection $options, Filters $filters)
    {

        switch ($this->visualable_type) {
            case \NovaBi\NovaDashboardManager\Models\Datavisualables\Value::class:

                $calculation = WidgetValueCalculation::make();

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
                $calculation = WidgetTrendCalculation::make();

                $dateValue = $filters->getFilterValue(DateRangeDefined::class);

                $result = $this->formatTrendData($dateValue, $calculation);

                return [
                    'labels' => $result['labels'],
                    'datasets' => [
                        'Widgets' => [
                            'name' => 'Widgets',
                            'data' => $result['values'],
                            'options' => []
                        ]
                    ]
                ];

                break;
        }
    }
}
