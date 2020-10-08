<?php

namespace NovaBi\NovaDashboardManager\Models\Dashboardables;

use NovaBi\NovaDashboardManager\Models\Dashboard;

use NovaBi\NovaDashboardManager\Traits\HasSchemalessAttributesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class BaseDashboardable extends Model
{
    use HasSchemalessAttributesTrait;

    public $timestamps = true;

    public $casts = [
        'extra_attributes' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(Str::singular(config('nova-dashboard-manager.tables.dashboards')) . '_standard');
    }

    public static function label()
    {
        return __('Databoard');
    }

    public function databoards()
    {
        return $this->morphMany(Dashboard::class, 'dashboardable');
    }


    public function filterable()
    {
        return $this->morphTo();
    }
}
