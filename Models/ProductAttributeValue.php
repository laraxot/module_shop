<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modules\Shop\Models\ProductAttributeValue
 *
 * @property int $id
 * @property int|null $attribute_value_id
 * @property int $product_attribute_id
 * @property string|null $product_custom_value
 * @property-read mixed $real_value
 * @property-read \Modules\Shop\Models\AttributeValue|null $value
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeValue whereAttributeValueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeValue whereProductAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeValue whereProductCustomValue($value)
 * @mixin \Eloquent
 */
class ProductAttributeValue extends Model {
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_attribute_id',
        'attribute_value_id',
        'product_custom_value',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['value'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['real_value'];

    /**
     * Return exact product attribute value.
     */
    public function getRealValueAttribute() {
        if ($this->product_custom_value) {
            return $this->product_custom_value;
        }

        return $this->value->value;
    }

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('attribute_value_product_attribute');
        return 'attribute_value_product_attribute';
    }

    public function value(): BelongsTo {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }
}