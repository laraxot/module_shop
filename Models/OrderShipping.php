<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Shop\Models\Shop\Carrier;

/**
 * Modules\Shop\Models\OrderShipping
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon $shipped_at
 * @property \Illuminate\Support\Carbon $received_at
 * @property \Illuminate\Support\Carbon $returned_at
 * @property string|null $tracking_number
 * @property string|null $tracking_number_url
 * @property mixed|null $voucher
 * @property int $order_id
 * @property int|null $carrier_id
 * @property-read \Modules\Shop\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|OrderShipping newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderShipping newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderShipping query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderShipping whereCarrierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderShipping whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderShipping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderShipping whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderShipping whereReceivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderShipping whereReturnedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderShipping whereShippedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderShipping whereTrackingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderShipping whereTrackingNumberUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderShipping whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderShipping whereVoucher($value)
 * @mixin \Eloquent
 */
class OrderShipping extends Model {
    protected $fillable=['id','created_at','updated_at','shipped_at','received_at','returned_at','tracking_number','tracking_number_url','voucher','order_id','carrier_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'shipped_at' => 'datetime',
        'received_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('order_shippings');
        return 'order_shippings';
    }

    public function order(): BelongsTo {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function carrier(): BelongsTo {
        return $this->belongsTo(Carrier::class, 'carrier_id');
    }
}