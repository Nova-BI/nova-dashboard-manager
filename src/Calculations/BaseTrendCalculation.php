<?php


namespace NovaBi\NovaDashboardManager\Calculations;

use Laravel\Nova\Metrics\Trend;

abstract class BaseTrendCalculation extends Trend
{
    use Calculatable;
}