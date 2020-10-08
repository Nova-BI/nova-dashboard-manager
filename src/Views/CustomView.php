<?php

namespace NovaBi\NovaDashboardManager\Views;

use DigitalCreative\NovaDashboard\Action;
use DigitalCreative\NovaDashboard\Examples\Actions\UniqueAction;
use DigitalCreative\NovaDashboard\Examples\Widgets\ExampleWidgetOne;
use DigitalCreative\NovaDashboard\View;
use DigitalCreative\NovaDashboard\Widget;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use NovaBi\NovaDashboardManager\Models\Dashboard as DashboardModel;

class CustomView extends View
{
    private $databoard;

    function __construct(DashboardModel $dashboard)
    {
        //$this->dashboard = $dashboard;
        // todo: remove duplicated query. Can be done after merging with nova-bi. Need to move all morphable models to nova-dashboard-manager
        $this->databoard = \NovaBi\NovaDashboardManager\Models\Dashboard::find($dashboard->id);
    }

    // not used
    public function titler($title = null)
    {
        return $this->databoard->name;
    }
    public function title(): string
    {
        return $this->databoard->name;
    }

    private function resolveActions(): Collection
    {
        return once(function () {
            return collect($this->actions())->filter(function (Action $action) {
                return $action->authorizedToSee(request());
            });
        });
    }

    private function resolveSchemas(): Collection
    {
        return $this->resolveWidgets()
            ->mapWithKeys(function (Widget $widget) {
                return [
                    $widget->uriKey() => $widget->getSchema(),
                ];
            });
    }

    private function resolveWidgets(): Collection
    {
        return once(function () {
            return collect($this->widgets())->filter(function (Widget $widget) {
                return $widget->authorizedToSee(request());
            });
        });
    }

    public function jsonSerialize(): array
    {
        return [
            'title' => $this->titler(),
            'uriKey' => $this->uriKey(),
            'filters' => $this->resolveFilters(),
            'actions' => $this->resolveActions(),
            'schemas' => $this->resolveSchemas(),
            'meta' => $this->meta(),
        ];
    }
    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public function uriKey(): string
    {
        return 'view-' . $this->databoard->id . '-default';
    }

    public function filters(): array
    {
        $filters = [];

        $this->databoard->datafilters->each(function ($datafilter, $key) use (&$filters) {
            $filters[] = (new $datafilter->filterable->filter)->withMeta(['default' => $datafilter->filterable->DefaultValue]);
        });
        return $filters;
    }

    public function actions(): array
    {
        // todo: how to get actions?
        return [
//            new UniqueAction(),
        ];
    }

    public function widgets(): array
    {
        $widgets = [];
        $this->databoard->datawidgets->each(function ($datawidget, $key) use (&$widgets) {
            $widgets[] =
                $datawidget->metricable->visualable->getVisualisation(
                    [
                        'title' => $datawidget->name,
                        'metric' => $datawidget->metricable,
                        'uriKey' => 'visual-'. $datawidget->id
                    ]
                );
            ;
        });
        return $widgets;
    }

}
