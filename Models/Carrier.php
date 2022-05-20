<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Shop\Models\Traits\HasSlug;

/**
 * Modules\Shop\Models\Carrier
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string|null $slug
 * @property string|null $logo
 * @property string|null $link_url
 * @property string|null $description
 * @property int $shipping_amount
 * @property bool $is_enabled
 * @method static \Illuminate\Database\Eloquent\Builder|Carrier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Carrier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Carrier query()
 * @method static \Illuminate\Database\Eloquent\Builder|Carrier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carrier whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carrier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carrier whereIsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carrier whereLinkUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carrier whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carrier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carrier whereShippingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carrier whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carrier whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Carrier extends Model {
    protected $fillable=['id','created_at','updated_at','name','slug','logo','link_url','description','shipping_amount','is_enabled'];

    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
        //return shopper_table('carriers');
        return 'carriers';
    }
}