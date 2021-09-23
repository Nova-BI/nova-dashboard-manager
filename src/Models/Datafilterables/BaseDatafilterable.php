<?php


namespace NovaBi\NovaDashboardManager\Models\Datafilterables;

use Illuminate\Support\Str;
use NovaBi\NovaDashboardManager\Models\Datafilter;
use NovaBi\NovaDashboardManager\Traits\HasSchemalessAttributesTrait;
use Illuminate\Database\Eloquent\Model;


class BaseDatafilterable extends Model
{
    use HasSchemalessAttributesTrait;

    public $timestamps = true;

    // mapping to Nova filter
    var $filter;


    public $casts = [
        'extra_attributes' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(Str::singular(config('nova-dashboard-manager.tables.filters')) . '_standard');
    }

    public function getDefaultValueAttribute()
    {
        return $this->extra_attributes->default_value;
    }

    public function setDefaultValueAttribute($value)
    {
        $this->extra_attributes->default_value = $value;
    }
    
    

    // 'filter' is already used by var $filter;
    
    // get the parent filter to retrieve e.g. name 
    public function filterParent() {
        return $this->morphOne(Datafilter::class, 'filterable');
    }
}
