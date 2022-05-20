<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Modules\Shop\Models\DiscountDetail
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $condition
 * @property int $total_use
 * @property string $discountable_type
 * @property int $discountable_id
 * @property int $discount_id
 * @property-read \Modules\Shop\Models\Discount $discount
 * @property-read Model|\Eloquent $discountable
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountDetail whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountDetail whereDiscountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountDetail whereDiscountableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountDetail whereDiscountableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountDetail whereTotalUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscountDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DiscountDetail extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discountable_type',
        'discountable_id',
        'condition',
        'discount_id',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['discount'];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('discountables');
        return 'discountables';
    }

    public function discount(): BelongsTo {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    public function discountable(): MorphTo {
        return $this->morphTo();
    }
}