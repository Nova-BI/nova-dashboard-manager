<?php

namespace NovaBi\NovaDashboardManager\Models\Datavisualables;

class Value extends BaseDatavisualable
{
    // mapping to visual
    public string $visual = \NovaBi\NovaDashboardManager\Models\Datavisualables\Visuals\Value::class;

    // supported card Widths
    var $cardWidthSupported = ['1/3'];

    public static function getResourceModel() {
        return \NovaBi\NovaDashboardManager\Nova\Datavisualables\Value::class;
    }

    public function getShowPreviousAttribute()
    {
        return $this->extra_attributes->show_previous;
    }

    public function setShowPreviousAttribute($value)
    {
        $this->extra_attributes->show_previous = $value;
    }

}
