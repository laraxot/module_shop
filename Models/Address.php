<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Shop\Models\System\Country;

/**
 * Modules\Shop\Models\Address
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $last_name
 * @property string $first_name
 * @property string|null $company_name
 * @property string $street_address
 * @property string|null $street_address_plus
 * @property string $zipcode
 * @property string $city
 * @property string|null $phone_number
 * @property bool $is_default
 * @property string $type
 * @property int|null $country_id
 * @property int $user_id
 * @property-read string $full_name
 * @property-read \Modules\LU\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereStreetAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereStreetAddressPlus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereZipcode($value)
 * @mixin \Eloquent
 */
class Address extends Model {
    public const TYPE_BILLING = 'billing';

    public const TYPE_SHIPPING = 'shipping';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'company_name',
        'street_address',
        'street_address_plus',
        'zipcode',
        'city',
        'phone_number',
        'is_default',
        'type',
        'user_id',
        'country_id',
    ];

    /**
     * The dynamic attributes from mutators that should be returned with the user object.
     *
     * @var array
     */
    protected $appends = [
        'full_name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'country',
    ];

    /**
     * Get the table associated with the model.
     */
    //*
    public function getTable(): string {
        //return shopper_table('user_addresses');
        return 'user_addresses';
    }

    //*/

    /**
     * Return Address Full Name.
     */
    public function getFullNameAttribute(): string {
        return $this->last_name
            ? $this->first_name.' '.$this->last_name
            : $this->first_name;
    }

    /**
     * Define if an address is default or not.
     */
    public function isDefault(): bool {
        return true === $this->is_default;
    }

    public function user(): BelongsTo {
        return $this->belongsTo(config('auth.providers.users.model', User::class), 'user_id');
    }

    public function country(): BelongsTo {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot() {
        parent::boot();

        static::creating(function ($address) {
            if ($address->is_default) {
                $address->user->addresses()->where('type', $address->type)->update([
                    'is_default' => false,
                ]);
            }
        });
    }
}