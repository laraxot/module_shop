<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Shop\Models\System\Country;

/**
 * Modules\Shop\Models\Inventory
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property string $email
 * @property string $street_address
 * @property string|null $street_address_plus
 * @property string $zipcode
 * @property string $city
 * @property string|null $phone_number
 * @property int $priority
 * @property string|null $latitude
 * @property string|null $longitude
 * @property bool $is_default
 * @property int|null $country_id
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory query()
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereStreetAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereStreetAddressPlus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereZipcode($value)
 * @mixin \Eloquent
 */
class Inventory extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'email',
        'phone_number',
        'street_address',
        'street_address_plus',
        'zipcode',
        'city',
        'priority',
        'longitude',
        'latitude',
        'is_default',
        'country_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('inventories');
        return 'inventories';
    }

    public function country(): BelongsTo {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * Boot the model.
     */
    protected static function boot() {
        parent::boot();

        static::creating(function ($inventory) {
            if ($inventory->is_default) {
                static::query()->update(['is_default' => false]);
            }
        });

        static::updating(function ($inventory) {
            if ($inventory->is_default) {
                static::query()->update(['is_default' => false]);
            }
        });
    }
}