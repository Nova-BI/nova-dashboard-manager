<?php

namespace NovaBi\NovaDashboardManager\Models;

use NovaBi\NovaDashboardManager\Traits\HasSchemalessAttributesTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Str;


class Datafilter extends Model implements Sortable
{
    use SortableTrait;

    use HasSchemalessAttributesTrait;

    public $casts = [
        'extra_attributes' => 'array',
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public $timestamps = true;

    public $translatable = ['description'];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('nova-dashboard-manager.tables.filters'));
    }

    public function filterable()
    {
        return $this->morphTo();
    }

    public function dashboard()
    {
        return $this->belongsToMany(Dashboard::class,
            Str::singular(config('nova-dashboard-manager.tables.dashboards')) . '_' . Str::singular(config('nova-dashboard-manager.tables.filters'))
        )->orderBy(config('nova-dashboard-manager.tables.dashboards') . '.sort_order', 'asc');
    }

}
