<?php

namespace NovaBi\NovaDashboardManager;

use DigitalCreative\NovaDashboard\NovaDashboard;
use DigitalCreative\NovaDashboard\Dashboard;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Laravel\Nova\Nova;
use NovaBi\NovaDashboardManager\Models\Dashboard as DashboardModel;
use NovaBi\NovaDashboardManager\Nova\DashboardConfiguration;
use NovaBi\NovaDashboardManager\Nova\Datafilter;
use NovaBi\NovaDashboardManager\Nova\Datawidget;

class DashboardManager extends NovaDashboard
{

    /**
     * @var mixed
     */
    public $dashboardConfigurationResource = DashboardConfiguration::class;

    /**
     * @var mixed
     */
    public $datawidgetResource = Datawidget::class;
    /**
     * @var mixed
     */
    public $datafilterResource = Datafilter::class;

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return View|null
     */
    public function renderNavigation(): ?View
    {
        if (config('nova-dashboard-manager.showToolMenu') === true) {
            return view('nova-dashboard-manager::navigation', ['dashboards' => $this->resolveDashboards()]);
        }
        return null;
    }


    protected function resolveDashboards(): Collection
    {
        return once(static function () {
            return DashboardModel::orderBy('sort_order')->get()
                ->filter(fn(DashboardModel $dashboard) => $dashboard->authorizedToSee(request()))
                ->mapInto(CustomDashboard::class);
        });
    }


    public function dashboards(): Collection
    {
        return $this->resolveDashboards();
    }

    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
//        Nova::script('nova-dashboard-manager', __DIR__ . '/../dist/js/tool.js');

        Nova::resources([
            $this->dashboardConfigurationResource,
            $this->datawidgetResource,
            $this->datafilterResource,
        ]);
        Nova::resources(config('nova-dashboard-manager.dashboardables.resources'));
        Nova::resources(config('nova-dashboard-manager.datafilterables.resources'));
        Nova::resources(config('nova-dashboard-manager.datametricables.resources'));
        Nova::resources(config('nova-dashboard-manager.datavisualables.resources'));
    }

    public function getCurrentActiveDashboard(string $dashboardKey): ?Dashboard
    {
        /**
         * @var Dashboard $dashboard
         */
        foreach ($this->resolveDashboards() as $dashboard) {
            if ($dashboard->resourceUri() === $dashboardKey) {
                if (is_string($dashboard) && class_exists($dashboard)) {
                    return new $dashboard();
                }
                return $dashboard;
            }
        }

        return null;

    }

}
