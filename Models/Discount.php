<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modules\Shop\Models\Discount
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_active
 * @property string $code
 * @property string $type
 * @property int $value
 * @property string $apply_to
 * @property string $min_required
 * @property string|null $min_required_value
 * @property string $eligibility
 * @property int|null $usage_limit
 * @property bool $usage_limit_per_user
 * @property int $total_use
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon|null $end_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Shop\Models\DiscountDetail[] $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder|Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount query()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereApplyTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereEligibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereMinRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereMinRequiredValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereTotalUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereUsageLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereUsageLimitPerUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereValue($value)
 * @mixin \Eloquent
 */
class Discount extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_active',
        'code',
        'type',
        'value',
        'apply_to',
        'min_required',
        'min_required_value',
        'eligibility',
        'usage_limit',
        'usage_limit_per_user',
        'total_use',
        'start_at',
        'end_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'usage_limit_per_user' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('discounts');
        return 'discounts';
    }

    /**
     * Determine if the discount code has reached his limit usage.
     */
    public function hasReachedLimit(): bool {
        if (null !== $this->usage_limit) {
            return $this->total_use === $this->usage_limit;
        }

        return false;
    }

    public function items(): HasMany {
        return $this->hasMany(DiscountDetail::class, 'discount_id');
    }
}