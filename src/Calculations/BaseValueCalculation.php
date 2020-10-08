<?php

namespace NovaBi\NovaDashboardManager\Calculations;

use Laravel\Nova\Metrics\Value;

abstract class BaseValueCalculation extends Value
{
    use Calculatable;
}