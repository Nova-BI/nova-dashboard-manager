<?php
declare(strict_types=1);

return [

    // want to show or hide the default tool menu?
    'showToolMenu' => true,

    'tables' => [
        'widget_configurations' => 'widget_configurations',
        'widgets' => 'widgets', // you need to change the widget table name in nova-dashboard.table_name as well
        'metrics' => 'metrics',
        'visuals' => 'visuals',
        'filters' => 'filters',
        'dashboards' => 'boards',
    ],

    'models' => [
        'widget_configuration' => \DigitalCreative\NovaDashboard\Models\Widget::class,
        'widget' => \NovaBi\NovaDashboardManager\Models\Datawidget::class,
        'filter' => \NovaBi\NovaDashboardManager\Models\Datafilter::class,
        'dashboard' => \NovaBi\NovaDashboardManager\Models\Dashboard::class
    ],


    'dashboardables' => [
        // Todo: make configurable
        'default' => 'todo',

        'resources' => [
            \NovaBi\NovaDashboardManager\Nova\Dashboardables\Standard::class, // example dashboardable
        ],

        // TODO: load all resources from these paths
        'paths' => []

    ],

    /*
     * register the available filters which can be configured for each dashboard
     */
    'datafilterables' => [
        // Todo: make configurable
        'default' => 'todo',

        'resources' => [
            \NovaBi\NovaDashboardManager\Nova\Datafilterables\DateRange::class,
            \NovaBi\NovaDashboardManager\Nova\Datafilterables\ActionEventTypes::class,

        ],

        // TODO: load all resources from these paths
        'paths' => []
    ],

    /*
     * register the available metrics which can be configured for each dashboard
     */

    'datametricables' => [
        // Todo: make configurable
        'default' => 'todo',

        'resources' => [
            \NovaBi\NovaDashboardManager\Nova\Datametricables\users::class, // example dashboardable
            \NovaBi\NovaDashboardManager\Nova\Datametricables\boards::class, // example dashboardable
            \NovaBi\NovaDashboardManager\Nova\Datametricables\widgets::class, // example dashboardable
            \NovaBi\NovaDashboardManager\Nova\Datametricables\actionEvents::class, // example dashboardable
            \NovaBi\NovaDashboardManager\Nova\Datametricables\actionEventTypes::class, // example dashboardable
        ],

        // TODO: load all resources from these paths
        'paths' => []
    ],

    /*
     * register the available visuals which can be configured for each metric
     */
    'datavisualables' => [
        // Todo: make configurable
        'default' => 'todo',

        /*
         * by using names you can later re-configure the visualisation for e.g. "Value" when there are new visualisation types available
         * in you metricable the types can be limit with short-names:
         *      var $visualisationTypes = ['Value', 'LineChart'];
         */
        'resources' => [
            'Value' => \NovaBi\NovaDashboardManager\Nova\Datavisualables\Value::class,
            'LineChart' => \NovaBi\NovaDashboardManager\Nova\Datavisualables\LineChart::class,
            'BarChart' => \NovaBi\NovaDashboardManager\Nova\Datavisualables\BarChart::class,
        ],

        // TODO: load all resources from these paths
        'paths' => []
    ],

];
