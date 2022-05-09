<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Shop\Models\Shop\PaymentMethod;
use Modules\Shop\Models\Traits\HasPrice;
use Modules\Shop\Models\User\Address;
use Modules\Shop\Models\User\User;
use Modules\Shop\Statuses\OrderStatus;

/**
 * Modules\Shop\Models\Order
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $number
 * @property int|null $price_amount
 * @property string $status
 * @property string $currency
 * @property int|null $shipping_total
 * @property string|null $shipping_method
 * @property string|null $notes
 * @property int|null $parent_order_id
 * @property int|null $shipping_address_id
 * @property int|null $user_id
 * @property int|null $payment_method_id
 * @property-read \Modules\LU\Models\User|null $customer
 * @property-read mixed $formatted_status
 * @property-read string $status_classes
 * @property-read string $total
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Shop\Models\OrderItem[] $items
 * @property-read int|null $items_count
 * @property-read \Modules\Shop\Models\OrderRefund|null $refund
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Query\Builder|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereParentOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePriceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Order withoutTrashed()
 * @mixin \Eloquent
 */
class Order extends Model {
    use HasPrice;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'status',
        'currency',
        'shipping_total',
        'shipping_method',
        'notes',
        'parent_order_id',
        'shipping_address_id',
        'payment_method_id',
        'price_amount',
        'user_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'total',
        'status_classes',
        'formatted_status',
    ];

    /**
     * Create a new Eloquent model instance.
     */
    public function __construct(array $attributes = []) {
        // Set default status in case there was none given
        if (! isset($attributes['status'])) {
            $this->setDefaultOrderStatus();
        }

        parent::__construct($attributes);
    }

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('orders');
        return 'orders';
    }

    /**
     * Return Total order price without shipping amount.
     */
    public function getTotalAttribute(): string {
        return $this->formattedPrice($this->total());
    }

    /**
     * Return status style classes.
     */
    public function getStatusClassesAttribute(): string {
        switch ($this->status) {
            case OrderStatus::PENDING:
                return 'border-yellow-200 bg-yellow-100 text-yellow-800';
            case OrderStatus::REGISTER:
                return 'border-blue-200 bg-blue-100 text-blue-800';
            case OrderStatus::PAID:
                return 'border-green-200 bg-green-100 text-green-800';
            case OrderStatus::CANCELLED:
                return 'border-red-200 bg-red-100 text-red-800';
        }
    }

    /**
     * Return the correct order status formatted.
     *
     * @return mixed
     */
    public function getFormattedStatusAttribute(): string {
        return OrderStatus::values()[$this->status];
    }

    public function total(): int {
        return $this->items->sum('total');
    }

    /**
     * Determine if an order can be cancelled.
     */
    public function canBeCancelled(): bool {
        if (OrderStatus::COMPLETED === $this->status || OrderStatus::PAID === $this->status) {
            return false;
        }

        return true;
    }

    /**
     * Determine if an order is not cancelled.
     */
    public function isNotCancelled(): bool {
        if (OrderStatus::CANCELLED === $this->status) {
            return false;
        }

        return true;
    }

    /**
     * Determine if on order is in pending status.
     */
    public function isPending(): bool {
        return OrderStatus::PENDING === $this->status;
    }

    /**
     * Determine if on order is in register status.
     */
    public function isRegister(): bool {
        return OrderStatus::REGISTER === $this->status;
    }

    /**
     * Return total order with shipping.
     */
    public function fullPriceWithShipping(): int {
        return $this->total() + $this->shipping_total;
    }

    public function shippingAddress(): BelongsTo {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function customer(): BelongsTo {
        return $this->belongsTo(config('auth.providers.users.model', User::class), 'user_id');
    }

    public function paymentMethod(): BelongsTo {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function refund(): HasOne {
        return $this->hasOne(OrderRefund::class);
    }

    public function items(): HasMany {
        return $this->hasMany(OrderItem::class);
    }

    protected function setDefaultOrderStatus(): void {
        $this->setRawAttributes(
            array_merge(
                $this->attributes,
                [
                    'status' => OrderStatus::PENDING,
                ]
            ),
            true
        );
    }
}