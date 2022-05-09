<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Shop\Models\Traits\Filetable;
use Modules\Shop\Models\Traits\HasSlug;

/**
 * Modules\Shop\Models\Brand
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string|null $slug
 * @property string|null $website
 * @property string|null $description
 * @property int $position
 * @property bool $is_enabled
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @method static Builder|Brand enabled()
 * @method static Builder|Brand newModelQuery()
 * @method static Builder|Brand newQuery()
 * @method static Builder|Brand query()
 * @method static Builder|Brand whereCreatedAt($value)
 * @method static Builder|Brand whereDescription($value)
 * @method static Builder|Brand whereId($value)
 * @method static Builder|Brand whereIsEnabled($value)
 * @method static Builder|Brand whereName($value)
 * @method static Builder|Brand wherePosition($value)
 * @method static Builder|Brand whereSeoDescription($value)
 * @method static Builder|Brand whereSeoTitle($value)
 * @method static Builder|Brand whereSlug($value)
 * @method static Builder|Brand whereUpdatedAt($value)
 * @method static Builder|Brand whereWebsite($value)
 * @mixin \Eloquent
 */
class Brand extends Model {
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
        'website',
        'description',
        'position',
        'seo_title',
        'seo_description',
        'is_enabled',
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
        //return shopper_table('brands');
        return 'brands';
    }

    public function scopeEnabled(Builder $query): Builder {
        return $query->where('is_enabled', true);
    }

    public function products(): HasMany {
        return $this->hasMany(config('shopper.system.models.product'));
    }
}