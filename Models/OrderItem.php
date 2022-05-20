<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Modules\Shop\Models\OrderItem
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $name The product name at the moment of buying
 * @property string|null $sku
 * @property string $product_type
 * @property int $product_id
 * @property int $quantity
 * @property int $unit_price_amount
 * @property int|null $order_id
 * @property-read int $total
 * @property-read \Modules\Shop\Models\Order|null $order
 * @property-read Model|\Eloquent $product
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereUnitPriceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderItem extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sku',
        'quantity',
        'unit_price_amount',
        'product_id',
        'product_type',
        'order_id',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('order_items');
        return 'order_items';
    }

    public function total(): int {
        return $this->unit_price_amount * $this->quantity;
    }

    public function getTotalAttribute(): int {
        return $this->total();
    }

    public function product(): MorphTo {
        return $this->morphTo();
    }

    public function order(): BelongsTo {
        return $this->belongsTo(Order::class, 'order_id');
    }
}