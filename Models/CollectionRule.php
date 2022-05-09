<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modules\Shop\Models\CollectionRule
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $rule
 * @property string $operator
 * @property string $value
 * @property int $collection_id
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionRule query()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionRule whereCollectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionRule whereOperator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionRule whereRule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionRule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionRule whereValue($value)
 * @mixin \Eloquent
 */
class CollectionRule extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rule',
        'operator',
        'value',
        'collection_id',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('collection_rules');
        return 'collection_rules';
    }

    public function getFormattedRule(): string {
        return [
            'product_title' => __('Product title'),
            'product_brand' => __('Product brand'),
            'product_category' => __('Product category'),
            'product_price' => __('Product price'),
            'compare_at_price' => __('Compare at price'),
            'inventory_stock' => __('Inventory stock'),
        ][$this->rule];
    }

    public function getFormattedOperator(): string {
        return [
            'equals_to' => __('Equals to'),
            'not_equals_to' => __('Not equals to'),
            'less_than' => __('Less than'),
            'greater_than' => __('Greater than'),
            'starts_with' => __('Starts with'),
            'ends_with' => __('End with'),
            'contains' => __('Contains'),
            'not_contains' => __('Not contains'),
        ][$this->operator];
    }

    public function collection(): BelongsTo {
        return $this->belongsTo(config('shopper.system.models.collection'), 'collection_id');
    }
}