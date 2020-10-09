# Nova Dashboard Manager

The Dashboard-Manager for [Nova-Dashboard](https://novapackages.com/packages/digital-creative/nova-dashboard) allows you to configure dashboards within your Nova-App

[![Latest Stable Version](https://poser.pugx.org/nova-bi/nova-dashboard-manager/v)](//packagist.org/packages/nova-bi/nova-dashboard-manager) [![Total Downloads](https://poser.pugx.org/nova-bi/nova-dashboard-manager/downloads)](//packagist.org/packages/nova-bi/nova-dashboard-manager) [![Latest Unstable Version](https://poser.pugx.org/nova-bi/nova-dashboard-manager/v/unstable)](//packagist.org/packages/nova-bi/nova-dashboard-manager) [![License](https://poser.pugx.org/nova-bi/nova-dashboard-manager/license)](//packagist.org/packages/nova-bi/nova-dashboard-manager)


![Laravel Nova Dashboard In Action](https://raw.githubusercontent.com/dcasia/nova-dashboard/master/screenshots/demo.gif)

# Installation:

You can install the package via composer:

    composer require nova-bi/nova-dashboard-manager

If you want to specify your own table names you need to edit the configurations before running the migrations:

    nova-dashboard.table_name
    nova-dashboard-manager.tables
    

**Recommended:** Publish Configuration File for adjusting model and table names of Nova-Dashboard

    php artisan vendor:publish --provider="DigitalCreative\NovaDashboard\ToolServiceProvider" --tag="config"


**Recommended:** Publish Configuration File for all configurations of Nova-Dashboard-Manager

    php artisan vendor:publish --provider="NovaBi\NovaDashboardManager\DashboardManagerServiceProvider" --tag="config"

    
**Optional:** Publish Migrations
    
    php artisan vendor:publish --provider="NovaBi\NovaDashboardManager\DashboardManagerServiceProvider" --tag="migrations"    

Run Migrations

    php artisan migrate


## Usage
Open `NovaServiceProvider.php` to add classes:

```php
use DigitalCreative\NovaDashboard\NovaDashboard;
use NovaBi\NovaDashboardManager\DashboardManager;
```

Enhance the tools() methods like this:
```php

public function tools()
{
    return [
        new DashboardManager(), // must be loaded first !!!
        new NovaDashboard(),
    ];
}
```


# Start with the Playground

The package comes with working playground examples so you can test the functionality and use the code as an example for your own implementations.

By default the Playground-Setup is configured, which will give you following basic metrics from you Nova installation:

- Users
- Boards
- Widgets
- ActionEvents
- ActionEventTypes

Following visualisations are currently available

- Value
- ChartJS Line
- ChartJS Bar


And these Filters are available:

- DateRange
- ActionEventTypes


Go to the Dashboard-Manager Tools menu and setup some demo widget, filters and dashboards.

**After configuration of your dashboard you need to reload Nova to show the new Menu-Item to access the dashboard**


# Develop and Register your own Metrics, Filters and Visuals


## Seperation of metric calculation and visualisation

The Metric classes are the container for all metric calculations. The calculations are adoptable to the supported visualisations, so e.g. within a `Users`-metric you can calculate e.g. the total number of users for a Value-Visualisation or provide Trend-Data for a Trend-Visualisation.

## configurable and re-usable

With custom configurations you can make your Boards, Metrics, Filters and Visualisations re-usable - check out `nova-bi/nova-dashboard-manager/src/Models/Datametricables/users.php` how to use the same metric to show the number of total users and users with verified email.

## Code Structure
Following the recommended structure to build your own Metrics, Filters and Visuals. Please check the sources of this package in `nova-bi/nova-dashboard-manager/src` for details


    /myDashboard
        /Calculations               All calculations - could be done in metrics as well
        /Models
            /Datafilterables        Models representing filters
            /Datametricables        Models representing metrics
            /Datavisualables        Models representing visuals
                /Visuals            Implementation of visuals, 
                                        must extend `DigitalCreative\ValueWidget\Widgets` 
                                        must use Trait \NovaBi\NovaDashboardManager\Models\Datavisualables\Visuals\Visuable
        /Nova
            /Datafilterables        Resources for filter models
            /Datametricables        Resources for metric models
            /Datavisualables        Resources for visual models


Register your sources in configurations:

    nova-dashboard-manager.datafilterables
    nova-dashboard-manager.datametricables
    nova-dashboard-manager.datavisualables

Now you can create new Filters and Metrics in your Dashboard configuration and attach them to dashboards.


## Debugging of Calculations

using Trait \NovaBi\NovaDashboardManager\Calculations\Calculatable`  you can view the raw SQL using the `debugQuery()` method

    dd($calculation->debugQuery($calculationCurrentValue->query()));
    
    


# Direct Access to Dashboards

The very nice [Collapsible Resource Manager](https://novapackages.com/packages/digital-creative/collapsible-resource-manager) package allows you to customize the menu structure. 

Configure `nova-dashboard-manager.showToolMenu` to `false` to hide the tool menue

With the following code the Dashboards and the configurations are directly accessible through the Menu (see *know issues* below - do you know how to solve this?)

```php

    // CollapsibleResourceManager
    use DigitalCreative\CollapsibleResourceManager\CollapsibleResourceManager;
    use DigitalCreative\CollapsibleResourceManager\Resources\Group;
    use DigitalCreative\CollapsibleResourceManager\Resources\NovaResource;
    use DigitalCreative\CollapsibleResourceManager\Resources\RawResource;
    use DigitalCreative\CollapsibleResourceManager\Resources\TopLevelResource;
    
    // Dashboard
    use DigitalCreative\NovaDashboard\NovaDashboard;
    use NovaBi\NovaDashboardManager\DashboardManager;
    use NovaBi\NovaDashboardManager\DashboardResource;
    use NovaBi\NovaDashboardManager\Nova\DashboardConfiguration;
    use NovaBi\NovaDashboardManager\Nova\Datafilter;
    use NovaBi\NovaDashboardManager\Nova\Datawidget;

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        $analyticsDataboards = [];
        $dashboards = (new DashboardManager)->dashboards();

        foreach ($dashboards as $dboard) {
            $analyticsDataboards[] = DashboardResource::make($dboard)->label($dboard->resourceLabel())->icon(faIcon('cog'));
        }

        return [
            new DashboardManager(), // must be loaded first !!!
            new NovaDashboard(), // must be loaded as well

            new CollapsibleResourceManager([
                'navigation' => [
                    TopLevelResource::make([
                        'label' => 'Databoards',
                        'icon' => '<svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="sidebar-icon"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>',
                        'resources' => $analyticsDataboards
                    ]),
                    TopLevelResource::make([
                        'label' => 'Admin',
                        'icon' => '<svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>',
                        'resources' => [
                            \App\Nova\User::class,
                            Group::make([
                                    'label' => 'Dashboard Configuration',
                                    'expanded' => false,
                                    'icon' => '',
                                    'resources' =>
                                        [
                                            NovaResource::make( DashboardConfiguration::class)->index(),
                                            NovaResource::make( Datafilter::class)->index(),
                                            NovaResource::make( Datawidget::class)->index(),
                                        ]
                                ]
                            )
                        ]
                    ]),
                ]
            ])
        ];
    }
```

## Known issue
- pages of the same route are not updated when navigating directly between views e.g. using [Collapsible Resource Manager
](https://novapackages.com/packages/digital-creative/collapsible-resource-manager). Therefor when switching between dashboards they are not updated - we hope to solve this soon.

    
## Contributing

If you would like to contribute please fork the project and submit a PR.

Check out https://github.com/Nova-BI/nova-databoards/issues for open development tasks and issues.

## Credits notice

This package is highly depending on following selection of packages from the huge range of excellent packages for laravel and nova.

- [Nova-Dashboard](https://novapackages.com/packages/digital-creative/nova-dashboard)
- [Collapsible Resource Manager](https://novapackages.com/packages/digital-creative/collapsible-resource-manager)
- [Inline MorphTo Field](https://novapackages.com/packages/digital-creative/nova-inline-morph-to)
- [Nova Field Dependency Container](https://novapackages.com/packages/epartment/nova-dependency-container)
- [Nova Global Filter](https://novapackages.com/packages/nemrutco/nova-global-filter)
- [Nova Sortable](https://novapackages.com/packages/optimistdigital/nova-sortable)
- [Nova Text Card](https://novapackages.com/packages/ericlagarda/nova-text-card)
- [laravel-schemaless-attributes](https://github.com/spatie/laravel-schemaless-attributes)    
    

## License

This software is released under [The MIT License (MIT)](LICENSE).    