<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use function count;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Cashier\Billable;
use Modules\Shop\Models\Shop\Order\Order;
use Modules\Shop\Models\Traits\CanHaveDiscount;
use Modules\Shop\Services\TwoFactor\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Modules\Shop\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Shop\Models\Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read string $birth_date_formatted
 * @property-read string $full_name
 * @property-read string $picture
 * @property-read string $roles_label
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Cashier\Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable {
    protected $fillable=['id','name','email','email_verified_at','password','remember_token','created_at','updated_at'];

    use Notifiable;
    use HasRoles;
    use CanHaveDiscount;
    use SoftDeletes;
    use TwoFactorAuthenticatable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'last_login_at',
        'last_login_ip',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'birth_date' => 'datetime',
    ];

    /**
     * The dynamic attributes from mutators that should be returned with the user object.
     *
     * @var array
     */
    protected $appends = [
        'full_name',
        'picture',
        'roles_label',
        'birth_date_formatted',
    ];

    /**
     * Bootstrap the model and its traits.
     */
    public static function boot() {
        parent::boot();

        static::deleting(function ($model) {
            $model->addresses()->delete();
            $model->roles()->detach();
            $model->orders()->delete();
        });
    }

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('users');
        return 'users';
    }

    /**
     * Define if user is an admin.
     */
    public function isAdmin(): bool {
        return $this->hasRole(config('shopper.system.users.admin_role'));
    }

    /**
     * Define if an user account is verified.
     */
    public function isVerified(): bool {
        return null !== $this->email_verified_at;
    }

    /**
     * Return User Full Name.
     */
    public function getFullNameAttribute(): string {
        return $this->last_name
            ? $this->first_name.' '.$this->last_name
            : $this->first_name;
    }

    public function getBirthDateFormattedAttribute(): string {
        if ($this->birth_date) {
            return $this->birth_date->formatLocalized('%d, %B %Y');
        }

        return __('Not defined');
    }

    /**
     * Get User roles name.
     */
    public function getRolesLabelAttribute(): string {
        $roles = $this->roles()->pluck('display_name')->toArray();

        if (count($roles)) {
            return implode(', ', array_map(fn ($item) => ucwords($item), $roles));
        }

        return 'N/A';
    }

    public function getPictureAttribute(): string {
        switch ($this->avatar_type) {
            case 'gravatar':
                return gravatar()->get($this->email);

            case 'storage':
                return Storage::disk(config('shopper.system.storage.disks.avatars'))->url($this->avatar_location);
        }
    }

    public function addresses(): HasMany {
        return $this->hasMany(Address::class);
    }

    public function orders(): HasMany {
        return $this->hasMany(Order::class);
    }
}