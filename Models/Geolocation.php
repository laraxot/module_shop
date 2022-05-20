<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Shop\Models\Geolocation
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property mixed|null $ip_api
 * @property mixed|null $extreme_ip_lookup
 * @property int $user_id
 * @property int|null $order_id
 * @method static \Illuminate\Database\Eloquent\Builder|Geolocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Geolocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Geolocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Geolocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geolocation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geolocation whereExtremeIpLookup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geolocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geolocation whereIpApi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geolocation whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geolocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Geolocation whereUserId($value)
 * @mixin \Eloquent
 */
class Geolocation extends Model {
    protected $fillable=['id','created_at','updated_at','deleted_at','ip_api','extreme_ip_lookup','user_id','order_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('users_geolocation_history');
        return 'users_geolocation_history';
    }
}