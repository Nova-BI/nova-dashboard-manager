<?php

namespace NovaBi\NovaDashboardManager\Models\Dashboardables;


class Standard extends BaseDashboardable
{


    /**
     * Get the displayable label of the scope entity.
     *
     * @return  string
     */
    public static function label()
    {
        return __('Default Databoard');
    }

}
