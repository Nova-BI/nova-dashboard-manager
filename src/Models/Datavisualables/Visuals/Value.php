<?php

namespace NovaBi\NovaDashboardManager\Models\Datavisualables\Visuals;

use DigitalCreative\NovaDashboard\Filters;
use DigitalCreative\ValueWidget\Widgets\ValueResult;
use DigitalCreative\ValueWidget\Widgets\ValueWidget;
use Illuminate\Support\Collection;

class Value extends ValueWidget
{
    use Visuable;

    public function resolveValue(Collection $options, Filters $filters): ValueResult
    {
        $result = $this->meta['metric']->calculate($options, $filters);

        $output = ValueResult::make()->currentValue($result['currentValue']);

        if ($this->meta['metric']->visualable->ShowPrevious) {
            $output->previousValue($result['previousValue']);
        }

        return $output;
    }
}
