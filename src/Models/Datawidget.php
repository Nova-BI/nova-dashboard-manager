<?php

namespace NovaBi\NovaDashboardManager\Models;

use NovaBi\NovaDashboardManager\Traits\HasSchemalessAttributesTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Str;

class Datawidget extends Model implements Sortable
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
        $this->setTable(config('nova-dashboard-manager.tables.widgets'));
    }

    public function dashboard()
    {
        return $this->belongsToMany(Dashboard::class,
            Str::singular(config('nova-dashboard-manager.tables.dashboards')) . '_' . Str::singular(config('nova-dashboard-manager.tables.widgets'))
        )->orderBy(config('nova-dashboard-manager.tables.dashboards').'.sort_order', 'asc');

    }

    public function metricable()
    {
        return $this->morphTo();
    }

    public function visualable() {
        return $this->metricable->visualable();
    }

}
