<?php

namespace NovaBi\NovaDashboardManager\Models\Datavisualables\Visuals;

use DigitalCreative\NovaDashboard\Filters;
use DigitalCreative\ValueWidget\Widgets\ValueResult;
use DigitalCreative\ValueWidget\Widgets\ValueWidget;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use NovaBi\NovaDashboardManager\Traits\DynamicMetricsTrait;
use Illuminate\Http\Request;
use Nemrutco\NovaGlobalFilter\GlobalFilterable;

class Value extends ValueWidget
{
    use Visuable;

    public function resolveValue(Collection $options, Filters $filters): ValueResult
    {
        $result = $this->meta['metric']->calculate($options, $filters);

        return ValueResult::make()
            ->currentValue($result['currentValue'])
            ->previousValue($result['previousValue']);
    }
}
