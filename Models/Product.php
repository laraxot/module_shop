<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Shop\Contracts\ReviewRateable;
use Modules\Shop\Models\Traits\CanHaveDiscount;
use Modules\Shop\Models\Traits\Filetable;
use Modules\Shop\Models\Traits\HasPrice;
use Modules\Shop\Models\Traits\HasSlug;
use Modules\Shop\Models\Traits\HasStock;
use Modules\Shop\Models\Traits\ReviewRateable as ReviewRateableTrait;

/**
 * Modules\Shop\Models\Product.
 *
 * @property int                                                                              $id
 * @property \Illuminate\Support\Carbon|null                                                  $created_at
 * @property \Illuminate\Support\Carbon|null                                                  $updated_at
 * @property \Illuminate\Support\Carbon|null                                                  $deleted_at
 * @property string                                                                           $name
 * @property string|null                                                                      $slug
 * @property string|null                                                                      $sku
 * @property string|null                                                                      $barcode
 * @property string|null                                                                      $description
 * @property int                                                                              $security_stock
 * @property bool                                                                             $featured
 * @property bool                                                                             $is_visible
 * @property int|null                                                                         $old_price_amount
 * @property int|null                                                                         $price_amount
 * @property int|null                                                                         $cost_amount
 * @property string|null                                                                      $type
 * @property int                                                                              $backorder
 * @property bool                                                                             $requires_shipping
 * @property \Illuminate\Support\Carbon|null                                                  $published_at
 * @property string|null                                                                      $seo_title
 * @property string|null                                                                      $seo_description
 * @property string|null                                                                      $weight_value
 * @property string                                                                           $weight_unit
 * @property string|null                                                                      $height_value
 * @property string                                                                           $height_unit
 * @property string|null                                                                      $width_value
 * @property string                                                                           $width_unit
 * @property string|null                                                                      $depth_value
 * @property string                                                                           $depth_unit
 * @property string|null                                                                      $volume_value
 * @property string                                                                           $volume_unit
 * @property int|null                                                                         $parent_id
 * @property int|null                                                                         $brand_id
 * @property \Illuminate\Database\Eloquent\Collection|\Modules\Shop\Models\ProductAttribute[] $attributes
 * @property int|null                                                                         $attributes_count
 * @property \Illuminate\Database\Eloquent\Collection|\Modules\Shop\Models\Channel[]          $channels
 * @property int|null                                                                         $channels_count
 * @property string|null                                                                      $formatted_price
 * @property int                                                                              $stock
 * @property int                                                                              $variations_stock
 * @property Product|null                                                                     $parent
 * @property \Illuminate\Database\Eloquent\Collection|Product[]                               $variations
 * @property int|null                                                                         $variations_count
 *
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static Builder|Product publish()
 * @method static Builder|Product query()
 * @method static Builder|Product whereBackorder($value)
 * @method static Builder|Product whereBarcode($value)
 * @method static Builder|Product whereBrandId($value)
 * @method static Builder|Product whereCostAmount($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDeletedAt($value)
 * @method static Builder|Product whereDepthUnit($value)
 * @method static Builder|Product whereDepthValue($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereFeatured($value)
 * @method static Builder|Product whereHeightUnit($value)
 * @method static Builder|Product whereHeightValue($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereIsVisible($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product whereOldPriceAmount($value)
 * @method static Builder|Product whereParentId($value)
 * @method static Builder|Product wherePriceAmount($value)
 * @method static Builder|Product wherePublishedAt($value)
 * @method static Builder|Product whereRequiresShipping($value)
 * @method static Builder|Product whereSecurityStock($value)
 * @method static Builder|Product whereSeoDescription($value)
 * @method static Builder|Product whereSeoTitle($value)
 * @method static Builder|Product whereSku($value)
 * @method static Builder|Product whereSlug($value)
 * @method static Builder|Product whereType($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereVolumeUnit($value)
 * @method static Builder|Product whereVolumeValue($value)
 * @method static Builder|Product whereWeightUnit($value)
 * @method static Builder|Product whereWeightValue($value)
 * @method static Builder|Product whereWidthUnit($value)
 * @method static Builder|Product whereWidthValue($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @mixin \Eloquent
 */
class Product extends Model implements ReviewRateable {
    use Filetable;
    use HasStock;
    use HasPrice;
    //"message" => "Undefined property: Modules\Shop\Models\Product::$slug (View: F:\var\www\base_geek\laravel\Modules\FormX\Resources\views\collective\fields\text\field.blade.php)"
    //use HasSlug;
    use CanHaveDiscount;
    use SoftDeletes;
    use SoftCascadeTrait;
    use ReviewRateableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'barcode',
        'description',
        'security_stock',
        'featured',
        'is_visible',
        'brand_id',
        'parent_id',
        'old_price_amount',
        'price_amount',
        'cost_amount',
        'type',
        'published_at',
        'backorder',
        'requires_shipping',
        'weight_value',
        'weight_unit',
        'height_value',
        'height_unit',
        'width_value',
        'width_unit',
        'depth_value',
        'depth_unit',
        'volume_value',
        'seo_title',
        'seo_description',
    ];

    /**
     * Cascade soft delete tables.
     *
     * @var array<string>
     */
    protected $softCascade = ['variations'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'featured' => 'boolean',
        'is_visible' => 'boolean',
        'requires_shipping' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('products');
        return 'products';
    }

    /**
     * Get the formatted price value.
     */
    public function getFormattedPriceAttribute(): ?string {
        if ($this->parent_id) {
            return $this->price_amount
                ? $this->formattedPrice($this->price_amount)
                : ($this->parent->price_amount ? $this->formattedPrice($this->parent->price_amount) : null);
        }

        return $this->price_amount
                ? $this->formattedPrice($this->price_amount)
                : null;
    }

    /**
     * Get the stock of all variations.
     */
    public function getVariationsStockAttribute(): int {
        $stock = 0;

        if ($this->variations->isNotEmpty()) {
            foreach ($this->variations as $variation) {
                $stock += $variation->stock;
            }
        }

        return $stock;
    }

    public function scopePublish(Builder $query): Builder {
        return $query->whereDate('published_at', '<=', now())
            ->where('is_visible', true);
    }

    public function variations(): HasMany {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent(): BelongsTo {
        return $this->belongsTo(self::class);
    }

    public function channels(): MorphToMany {
        return $this->morphedByMany(Channel::class, 'productable', 'product_has_relations');
    }

    public function relatedProducts(): MorphToMany {
        return $this->morphedByMany(config('shopper.system.models.product'), 'productable', 'product_has_relations');
    }

    public function categories(): MorphToMany {
        return $this->morphedByMany(config('shopper.system.models.category'), 'productable', 'product_has_relations');
    }

    public function collections(): MorphToMany {
        return $this->morphedByMany(config('shopper.system.models.collection'), 'productable', 'product_has_relations');
    }

    public function brand(): BelongsTo {
        return $this->belongsTo(config('shopper.system.models.brand'), 'brand_id');
    }

    public function attributes(): HasMany {
        return $this->hasMany(ProductAttribute::class);
    }
}