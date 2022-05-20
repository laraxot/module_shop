<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;
use Modules\Geo\Models\Place;

/**
 * Modules\Shop\Models\Shop.
 *
 * @property int                                                                     $id
 * @property string|null                                                             $shop_type
 * @property string|null                                                             $phone
 * @property string|null                                                             $website
 * @property string|null                                                             $email
 * @property string|null                                                             $vat_number
 * @property string|null                                                             $tax_code
 * @property string                                                                  $ratings_avg
 * @property int                                                                     $ratings_count
 * @property int                                                                     $status_id
 * @property int                                                                     $is_reclamed
 * @property int                                                                     $booking_enable
 * @property int                                                                     $order_enable
 * @property string|null                                                             $created_by
 * @property string|null                                                             $updated_by
 * @property \Illuminate\Support\Carbon|null                                         $created_at
 * @property \Illuminate\Support\Carbon|null                                         $updated_at
 * @property string|null                                                             $guid
 * @property string|null                                                             $image_src
 * @property string|null                                                             $lang
 * @property string|null                                                             $post_type
 * @property string|null                                                             $subtitle
 * @property string|null                                                             $title
 * @property string|null                                                             $txt
 * @property string|null                                                             $user_handle
 * @property \Illuminate\Database\Eloquent\Collection|\Modules\Xot\Models\Image[]    $images
 * @property int|null                                                                $images_count
 * @property \Illuminate\Database\Eloquent\Collection|Place[]                        $places
 * @property int|null                                                                $places_count
 * @property \Illuminate\Database\Eloquent\Collection|\Modules\Lang\Models\Post[]    $posts
 * @property int|null                                                                $posts_count
 * @property \Illuminate\Database\Eloquent\Collection|\Modules\Shop\Models\Product[] $products
 * @property int|null                                                                $products_count
 * @property mixed                                                                   $url
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Shop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModelLang ofItem(string $guid)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereBookingEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereIsReclamed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereOrderEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereRatingsAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereRatingsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereShopType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereTaxCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereVatNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModelLang withPost(string $guid)
 * @mixin \Eloquent
 *
 * @property \Modules\Lang\Models\Post|null $post
 * @property string|null                    $locality
 * @property string|null                    $locality_slug
 * @property Place|null                     $place
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereLocality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereLocalitySlug($value)
 */
class Shop extends BaseModelLang {
    protected $fillable = [
        'id', 'shop_type', 'phone', 'email', 'website',
        'is_reclamed', 'booking_enable', 'order_enable',
        'status_id', 'vat_number', 'tax_code',
        'ratings_avg', 'ratings_count',
        'locality', // locality nella relazione place mi serve per ridure le query
    ];

    /**
     * Relations.
     */
    public function products(): HasMany {
        return $this->hasMany(Product::class)->with('post');
    }

    public function place(): MorphOne {
        return $this->morphOne(Place::class, 'post');
    }

    public function places(): MorphMany {
        return $this->morphMany(Place::class, 'post');
    }

    public function shopCats() {
        return $this->belongsToMany(ShopCat::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location() {
        if (null == $this->locality) {
            $this->locality = 'unknown';
            $this->save();
        }

        $row = $this->hasOne(Location::class, 'locality', 'locality');
        if (! $row->exists()) {
            $row = Location::query()->firstOrCreate(['locality' => $this->locality]);
            $post = $row->post()->firstOrCreate(
                [
                    'title' => $this->locality,
                    'guid' => Str::slug($this->locality),
                    'lang' => app()->getLocale(),
                ]
            );

            return $this->hasOne(Location::class, 'locality', 'locality');
        }

        return $row;
    }

    //--------------------- Mutators ------------------
    public function getLocalityAttribute(?string $value): ?string {
        if (null !== $value) {
            return $value;
        }
        $value = $this->place->locality;
        $this->locality = $value;
        $this->save();

        return $value;
    }

    public function getLocalitySlugAttribute(?string $value): ?string {
        if (null !== $value) {
            return $value;
        }
        $value = str_slug($this->place->locality);
        $this->locality_slug = $value;
        $this->save();

        return $value;
    }
}
