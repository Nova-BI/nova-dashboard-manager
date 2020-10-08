<?php

namespace NovaBi\NovaDashboardManager\Models\Datafilterables;

class DateRange extends BaseDatafilterable
{
    // mapping to filter
    var $filter = \NovaBi\NovaDashboardManager\Nova\Filters\DateRangeDefined::class;

    // supported card Widths
    var $cardWidthSupported = ['1/3'];


    public $casts = [
        'extra_attributes' => 'array'
    ];

}
