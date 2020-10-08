<?php

namespace NovaBi\NovaDashboardManager\Calculations;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Makeable;
use Laravel\Nova\Query\ApplyFilter;
use NovaBi\NovaDashboardManager\Nova\Filters\ActionEventType;

trait Calculatable
{


    use Makeable;

    /**
     * The element's component.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    public $query;

    /**
     * Create a new calculation.
     *
     */
    public function __construct()
    {
        $this->query = $this->newQuery();
    }

    public function __clone()
    {
        $this->query = clone $this->query;
    }

    public function query()
    {
        return $this->query;
    }

    abstract public function newQuery();

    public function applyFilter($filters, $filterClass, $options = [])
    {
        $builder = $this->query;

        $this->query = tap($builder, function (Builder $builder) use ($filters, $filterClass, $options) {
            $filters->filters()
                ->each(static function (ApplyFilter $applyFilter) use ($builder, $filterClass, $options) {
                    if (get_class($applyFilter->filter) == $filterClass) {
                        if ($filterClass == ActionEventType::class) {
//                        dd($applyFilter->value);

                        }
                        $applyFilter->filter->withMeta($options)->apply(resolve(NovaRequest::class), $builder, $applyFilter->value);
                    }
                });
        });
        return $this;
    }


    public function debugQuery(Builder $query)
    {
        $sql = vsprintf(str_replace(array('?'), array('\'%s\''), $query->toSql()), $query->getBindings());
        return $sql;
    }


}
