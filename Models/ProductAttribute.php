<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modules\Shop\Models\ProductAttribute
 *
 * @property int $id
 * @property int $product_id
 * @property int $attribute_id
 * @property-read \Modules\Shop\Models\Attribute $attribute
 * @property-read \Modules\Shop\Models\Product $product
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Shop\Models\ProductAttributeValue[] $values
 * @property-read int|null $values_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereProductId($value)
 * @mixin \Eloquent
 */
class ProductAttribute extends Model {
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
        'product_id',
        'attribute_id',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'attribute',
        'values',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        return 'product_attributes';
    }

    public function attribute(): BelongsTo {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function values(): HasMany {
        return $this->hasMany(ProductAttributeValue::class);
    }
}