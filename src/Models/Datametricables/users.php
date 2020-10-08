<?php

namespace NovaBi\NovaDashboardManager\Models\Datametricables;


use DigitalCreative\NovaDashboard\Examples\Filters\Category;
use DigitalCreative\NovaDashboard\Examples\Filters\Date;
use DigitalCreative\NovaDashboard\Examples\Filters\Quantity;
use DigitalCreative\NovaDashboard\Filters;
use Illuminate\Support\Collection;
use Laravel\Nova\Http\Requests\NovaRequest;
use NovaBi\NovaDashboardManager\Calculations\UserTrendCalculation;
use NovaBi\NovaDashboardManager\Calculations\UserValueCalculation;
use App\User;
use Illuminate\Http\Request;
use NovaBi\NovaDashboardManager\Nova\Filters\DateRangeDefined;

class users extends BaseDatametricable
{
    /*
     * configure supported visualisationTypes
     * methode 'calculate' must return a valid calculation
     */

    var $visualisationTypes = [
        'Value' => 'Number of Users',
        'LineChart' => 'Linechart-Trend of Users',
        'BarChart' => 'Barchart-Trend of Users'
    ];

    public static function getResourceModel()
    {
        return \NovaBi\NovaDashboardManager\Nova\Datametricables\users::class;
    }

    public function getOnlyVerifiedEmailAttribute()
    {
        return $this->extra_attributes->only_verified_email;
    }


    public function setOnlyVerifiedEmailAttribute($value)
    {
        $this->extra_attributes->only_verified_email = $value;
    }


    public function calculate(Collection $options, Filters $filters)
    {
        switch ($this->visualable_type) {
            case \NovaBi\NovaDashboardManager\Models\Datavisualables\Value::class :

                $calcuation = UserValueCalculation::make();

                if ($this->only_verified_email) {
                    $calcuation = $calcuation->verified();
                }

                // option 1
                // get filter values and calculate result
                // $dateValue = $filters->getFilterValue(DateRangeDefined::class);

                // option 2
                // apply filter with options
                // $calcuation->applyFilter($filters, DateRangeDefined::class,
                //     ['dateColumn' => 'created_at']
                // );


                $calcuationCurrentValue = (clone $calcuation)->applyFilter($filters, DateRangeDefined::class,
                    ['dateColumn' => 'created_at']
                );

                $calcuationPreviousValue = (clone $calcuation)->applyFilter($filters, DateRangeDefined::class,
                    ['dateColumn' => 'created_at', 'previousRange' => true]
                );

                // alternativ approach: use Nova Value calculations
                // $calcuation->count($calcuationCurrentValue->query());

                return [
                    'currentValue' => $calcuationCurrentValue->query()->get()->count(),
                    'previousValue' => $calcuationPreviousValue->query()->get()->count()
                ];
                break;

            case \NovaBi\NovaDashboardManager\Models\Datavisualables\LineChart::class :
            case \NovaBi\NovaDashboardManager\Models\Datavisualables\BarChart::class :

                // Using Nova Trend calculations
                $calcuation = UserTrendCalculation::make();

                $dateValue = $filters->getFilterValue(DateRangeDefined::class);

                $result = $this->formatTrendData($dateValue, $calcuation);


                return [
                    'labels' => $result['labels'],
                    'datasets' => [
                        'Users' => [
                            'name' => 'Users',
                            'data' => $result['values'],
                        ]
                    ],
                    'options' => []
                ];

                break;
        }
    }

}
