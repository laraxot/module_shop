<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Shop\Models\Traits\Filetable;
use Modules\Shop\Models\Traits\HasSlug;

/**
 * Modules\Shop\Models\Category
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string|null $slug
 * @property string|null $description
 * @property int $position
 * @property bool $is_enabled
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property int|null $parent_id
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $childs
 * @property-read int|null $childs_count
 * @property-read string|null $parent_name
 * @property-read Category|null $parent
 * @method static Builder|Category enabled()
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereDescription($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereIsEnabled($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereParentId($value)
 * @method static Builder|Category wherePosition($value)
 * @method static Builder|Category whereSeoDescription($value)
 * @method static Builder|Category whereSeoTitle($value)
 * @method static Builder|Category whereSlug($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model {
    use Filetable;
    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'position',
        'is_enabled',
        'seo_title',
        'seo_description',
        'parent_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('categories');

        return 'categories';
    }

    public function scopeEnabled(Builder $query): Builder {
        return $query->where('is_enabled', true);
    }

    public function getParentNameAttribute(): ?string {
        if (null !== $this->parent_id) {
            return $this->parent->name;
        }

        return null;
    }

    public function childs(): HasMany {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent(): BelongsTo {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function products(): MorphToMany {
        return $this->morphToMany(config('shopper.system.models.product'), 'productable', 'product_has_relations');
    }
}