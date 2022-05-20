<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modules\Shop\Models\AttributeValue
 *
 * @property int $id
 * @property string $value
 * @property string $key
 * @property int|null $position
 * @property int $attribute_id
 * @property-read \Modules\Shop\Models\Attribute $attribute
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue whereValue($value)
 * @mixin \Eloquent
 */
class AttributeValue extends Model {
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
        'value',
        'key',
        'position',
        'attribute_id',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('attribute_values');
        return 'attribute_values';
    }

    public function attribute(): BelongsTo {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}