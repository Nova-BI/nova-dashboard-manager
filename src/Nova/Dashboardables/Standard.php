<?php

namespace NovaBi\NovaDashboardManager\Nova\Dashboardables;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;

class Standard extends BaseBoard
{
    /**
     * The model the resource corresponds to.
     *
     * @var  string
     */
    public static $model = \NovaBi\NovaDashboardManager\Models\Dashboardables\Standard::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return  array
     */
    public function boardFields(Request $request)
    {
        return [
//            Text::make(__('my First Value'), 'my_first_value'),
//            Text::make(__('my Second Value'), 'my_second_value'),
        ];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return  string
     */
    public static function label()
    {
        return __('Standard Dashboard');
    }


    /**
     * Get the displayable singular label of the resource.
     *
     * @return  string
     */
    public static function singularLabel()
    {
        return __('Standard Dashboard');
    }
}
