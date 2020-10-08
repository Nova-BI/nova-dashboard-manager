<?php

namespace NovaBi\NovaDashboardManager\Traits;


use NovaBi\NovaDashboardManager\Models\Datawidget;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

trait DynamicMetricsTrait
{

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        if (isset($this->meta) && count($this->meta) > 0) {
            $uriKey = $this->baseUriKey . '$' . http_build_query($this->meta);
            return $uriKey;
        }
        return $this->baseUriKey;
    }

    /**
     * Resolve parameters from URI
     *
     * @param $request Request
     *
     * @return array
     *
     */

    public function getParameters(Request $request)
    {
        $path = $request->getPathInfo();
        $p = Arr::last(explode('$', $path));
        $parameters = [];
        parse_str($p, $parameters);
        return $parameters;
    }

    public function name()
    {
        $meta = $this->meta();
        if (isset($meta['label'])) {
            return parent::name() . ': ' . $meta['label'];
        } else {
            return parent::name();
        }
    }


    public function widget()
    {
        return Datawidget::find($this->meta['widget_id']);
    }

    public function metric() {
        return $this->widget()->metricable;
    }

    public function metricCalculate(Request $request, $visual) {
        return $this->widget()->metricable->calculate($request, $visual);
    }
}
