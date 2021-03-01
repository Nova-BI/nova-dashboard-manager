<?php

namespace NovaBi\NovaDashboardManager\Nova\Datametricables;

use App\Nova\Resource;
use NovaBi\NovaDashboardManager\Models\Datavisualables\Value;
use NovaBi\NovaDashboardManager\Traits\LoadMorphablesTrait;
use DigitalCreative\InlineMorphTo\HasInlineMorphToFields;
use DigitalCreative\InlineMorphTo\InlineMorphTo;
use Illuminate\Http\Request;

class BaseMetric extends Resource
{
    use LoadMorphablesTrait;

    use HasInlineMorphToFields;

    public static $displayInNavigation = false;

    /**
     * @var int sort order of morphables
     */
    public static $sort_order = 1;


    /**
     * The model the resource corresponds to.
     *
     * @var  string
     */
    public static $model = \NovaBi\NovaDashboardManager\Models\Datametricables\BaseDatametricable::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var  string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var  array
     */
    public static $search = [];

        /**
     * Indicates if the resource should be globally searchable.
     *
     * @var bool
     */
    public static $globallySearchable = false;    
    
    /**
     * Indicates if the resource should be searchable on the index view.
     *
     * @var bool
     */
    public static $searchable = false;    
    
    
    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return  array
     */
    public function fields(Request $request)
    {
        return array_merge(
            [
                InlineMorphTo::make(__('Visualisation'), 'visualable')
                    ->types($this->loadVisualables())
                    ->default(\NovaBi\NovaDashboardManager\Models\Datavisualables\Value::class)
                    ->typeUpdateable(true)
                    ->onlyOnForms()
                    ->required()
            ],
            $this->metricFields($request),
        );
    }


    /**
     * Get the fields displayed by the metric resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return  array
     */
    public function metricFields(Request $request)
    {
        return [];
    }

    /**
     * return the available Visuals for current metric
     *
     * @return  array
     */
    public function loadVisualables()
    {
//        $loadPath = base_path(config('nova-dashboard-manager.path') . 'Nova/Datavisualables');
//        $datavisualables = $this->loadMorphables($loadPath);

        /*
         * load all visualisationTypes from configuration
         * the metric-methode 'calculate' must return a valid calculation
         */

        $datavisualables = config('nova-dashboard-manager.datavisualables.resources');
        $datavisualables = array_filter($datavisualables, function ($visual) {
            return in_array(class_basename($visual), array_keys($this->newModel()->getVisualisationTypes()));
        });




        return $datavisualables;
    }
}
