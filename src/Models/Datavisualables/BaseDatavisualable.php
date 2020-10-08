<?php


namespace NovaBi\NovaDashboardManager\Models\Datavisualables;

use NovaBi\NovaDashboardManager\Models\Datametricables\BaseDatametricable;
use NovaBi\NovaDashboardManager\Traits\HasSchemalessAttributesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;



class BaseDatavisualable extends Model
{
    use HasSchemalessAttributesTrait;

    public $timestamps = true;

    // mapping to visual
    var $visual = \NovaBi\NovaDashboardManager\Models\Datavisualables\Visuals\Value::class;

    public $casts = [
        'extra_attributes' => 'array',
    ];

    // all available card Widths
    var $cardWidthAll = ['1/3' => '1/3 width', '2/3' => '2/3 width', 'full' => 'full Width'];

    // supported card Widths
    var $cardWidthSupported = ['1/3', '2/3', 'full'];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(Str::singular(config('nova-dashboard-manager.tables.visuals')) . '_standard');
    }

    public function metrics()
    {
        return $this->morphMany(BaseDatametricable::class, 'visualables');
    }

    public function getVisualisation($options)
    {
        $classname = $this->visual;
        return (new $classname())->withMeta($options);
    }

    /**
     * @return string[]
     */
    public function getCardWidthAll(): array
    {
        return $this->cardWidthAll;
    }

    /**
     * @return string[]
     */
    public function getCardWidthSupported(): array
    {
        return $this->cardWidthSupported;
    }

    public function setCardWidthAttribute($value)
    {
        $this->extra_attributes->card_width = $value;
    }

    public function getCardWidthAttribute()
    {
        return $this->extra_attributes->card_width;
    }


    // examples for custom attributes

    public function getMyFirstValueAttribute()
    {
        return $this->extra_attributes->my_first_value;
    }


    public function setMyFirstValueAttribute($value)
    {
        $this->extra_attributes->my_first_value = $value;
    }


    public function getMySecondValueAttribute()
    {
        return $this->extra_attributes->my_second_value;
    }


    public function setMySecondValueAttribute($value)
    {
        $this->extra_attributes->my_second_value = $value;
    }
}
