<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Shop\Models\User\User;
use Modules\Shop\Statuses\OrderRefundStatus;

/**
 * Modules\Shop\Models\OrderRefund
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $refund_reason
 * @property string|null $refund_amount
 * @property string $status
 * @property string $notes
 * @property int $order_id
 * @property int|null $user_id
 * @property-read \Modules\Shop\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRefund newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRefund newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRefund query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRefund whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRefund whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRefund whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRefund whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRefund whereRefundAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRefund whereRefundReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRefund whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRefund whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRefund whereUserId($value)
 * @mixin \Eloquent
 */
class OrderRefund extends Model {
    protected $fillable = ['id', 'created_at', 'updated_at', 'refund_reason', 'refund_amount', 'status', 'notes', 'order_id', 'user_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Create a new Eloquent model instance.
     */
    public function __construct(array $attributes = []) {
        // Set default status in case there was none given
        if (! isset($attributes['status'])) {
            $this->setDefaultOrderRefundStatus();
        }

        parent::__construct($attributes);
    }

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('order_refunds');
        return 'order_refunds';
    }

    public function customer(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order(): BelongsTo {
        return $this->belongsTo(Order::class, 'order_id');
    }

    protected function setDefaultOrderRefundStatus(): void {
        $this->setRawAttributes(
            array_merge(
                $this->attributes,
                [
                    'status' => OrderRefundStatus::PENDING,
                ]
            ),
            true
        );
    }
}