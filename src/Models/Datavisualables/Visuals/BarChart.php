<?php

namespace NovaBi\NovaDashboardManager\Models\Datavisualables\Visuals;

use DigitalCreative\ChartJsWidget\BarChartWidget;
use DigitalCreative\ChartJsWidget\BarChatStyle;
use DigitalCreative\NovaDashboard\Filters;
use DigitalCreative\ChartJsWidget\Color;
use DigitalCreative\ChartJsWidget\DataSet;
use DigitalCreative\ChartJsWidget\Gradient;
use DigitalCreative\ChartJsWidget\LineChartWidget;
use DigitalCreative\ChartJsWidget\Style;
use DigitalCreative\ChartJsWidget\ValueResult;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use NovaBi\NovaDashboardManager\Traits\DynamicMetricsTrait;
use Illuminate\Http\Request;
use Nemrutco\NovaGlobalFilter\GlobalFilterable;

class BarChart extends BarChartWidget
{
    use Visuable;

    public function resolveValue(Collection $options, Filters $filters): ValueResult
    {
        $result = $this->meta['metric']->calculate($options, $filters);

        $configuration = Style::make();

        $valueResult = ValueResult::make()
            ->labels($result['labels']);

        foreach ($result['datasets'] as $label => $dset) {
            $dataSet = DataSet::make($dset['name'], $dset['data'], $configuration);
            $valueResult->addDataset($dataSet);
        }
        return $valueResult;


        ///------------------- original example code

        $configuration = BarChatStyle::make()
            ->hoverBackgroundColor('green');

        $dataSet1 = DataSet::make('Sample A', $this->getRandomData(), $configuration);
        $dataSet2 = DataSet::make('Sample B', $this->getRandomData(), $configuration);
        $dataSet3 = DataSet::make('Sample C', $this->getRandomData(), $configuration);
        $dataSet4 = DataSet::make('Sample D', $this->getRandomData(), $configuration);

        return $this->value()
            ->labels($this->getRandomData())
            ->addDataset($dataSet1, $dataSet2, $dataSet3, $dataSet4);

    }

    public function defaults(): array
    {
        return [
            'layout' => [
                'padding' => [
                    'left' => 50,
                    'right' => 50,
                    'top' => 50,
                    'bottom' => 50,
                ]
            ],
            'legend' => [
                'display' => false
            ]
        ];
    }


    public function getRandomData($min = 1, $max = 100): array
    {
        return [
            random_int($min, $max),
            random_int($min, $max),
            random_int($min, $max),
            random_int($min, $max),
            random_int($min, $max),
            random_int($min, $max),
            random_int($min, $max),
            random_int($min, $max),
            random_int($min, $max),
        ];
    }
}
