<?php

namespace NovaBi\NovaDashboardManager\Models\Datafilterables;

class ActionEventTypes extends BaseDatafilterable
{
    // mapping to filter
    var $filter = \NovaBi\NovaDashboardManager\Nova\Filters\ActionEventType::class;

    // supported card Widths
    var $cardWidthSupported = ['1/3'];
}
