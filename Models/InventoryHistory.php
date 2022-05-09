<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Shop\Models\User\User;

/**
 * Modules\Shop\Models\InventoryHistory
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $stockable_type
 * @property int $stockable_id
 * @property string|null $reference_type
 * @property int|null $reference_id
 * @property int $quantity
 * @property int $old_quantity
 * @property string|null $event
 * @property string|null $description
 * @property int $inventory_id
 * @property int $user_id
 * @property-read string $adjustment
 * @property-read \Modules\Shop\Models\Inventory $inventory
 * @property-read Model|\Eloquent $reference
 * @property-read Model|\Eloquent $stockable
 * @property-read \Modules\LU\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryHistory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryHistory whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryHistory whereInventoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryHistory whereOldQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryHistory whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryHistory whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryHistory whereReferenceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryHistory whereStockableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryHistory whereStockableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryHistory whereUserId($value)
 * @mixin \Eloquent
 */
class InventoryHistory extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stockable_type',
        'stockable_id',
        'reference_type',
        'reference_id',
        'inventory_id',
        'event',
        'quantity',
        'old_quantity',
        'description',
        'user_id',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'inventory',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'adjustment',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('inventory_histories');
        return 'inventory_histories';
    }

    public function getAdjustmentAttribute(): string {
        if ($this->old_quantity > 0) {
            return '+'.$this->old_quantity;
        }

        return $this->old_quantity;
    }

    public function inventory(): BelongsTo {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(config('auth.providers.users.model', User::class), 'user_id');
    }

    public function stockable(): MorphTo {
        return $this->morphTo();
    }

    public function reference(): MorphTo {
        return $this->morphTo();
    }
}