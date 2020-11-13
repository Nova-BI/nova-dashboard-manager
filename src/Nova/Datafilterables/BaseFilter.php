<?php

namespace NovaBi\NovaDashboardManager\Nova\Datafilterables;

use App\Nova\Resource;
use NovaBi\NovaDashboardManager\Models\Datafilterables\BaseDatafilterable;
use NovaBi\NovaDashboardManager\Traits\LoadMorphablesTrait;
use DigitalCreative\InlineMorphTo\HasInlineMorphToFields;
use DigitalCreative\InlineMorphTo\InlineMorphTo;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class BaseFilter extends Resource
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
//    public static $model = BaseDatafilterable::class;

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
            ],
            $this->filterFields($request),

            []
        );
    }

    /**
     * Get the fields displayed by the visual resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return  array
     */
    public function filterFields(Request $request)
    {
        return [];
    }

    public function getFilterClass()
    {
        return (new static::$model)->filter;
    }

}
