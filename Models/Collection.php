<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Shop\Models\Traits\Filetable;
use Modules\Shop\Models\Traits\HasSlug;

/**
 * Modules\Shop\Models\Collection
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string|null $slug
 * @property string|null $description
 * @property string $type
 * @property string|null $sort
 * @property string|null $match_conditions
 * @property \Illuminate\Support\Carbon $published_at
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Shop\Models\CollectionRule[] $rules
 * @property-read int|null $rules_count
 * @method static \Illuminate\Database\Eloquent\Builder|Collection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection query()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereMatchConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Collection extends Model {
    use Filetable;
    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'published_at',
        'type',
        'sort',
        'match_conditions',
        'seo_title',
        'seo_description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('collections');
        return 'collections';
    }

    /**
     * Return the correct formatted word of the first collection rule.
     */
    public function firstRule(): string {
        $condition = $this->rules()->first();

        return $condition->getFormattedRule().' '.$condition->getFormattedOperator().' '.$condition->value;
    }

    public function products(): MorphToMany {
        return $this->morphToMany(config('shopper.system.models.product'), 'productable', 'product_has_relations');
    }

    public function rules(): HasMany {
        return $this->hasMany(CollectionRule::class, 'collection_id');
    }
}