<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Modules\Shop\Models\Traits\HasSlug;

/**
 * Modules\Shop\Models\PaymentMethod
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $title
 * @property string|null $slug
 * @property string|null $logo
 * @property string|null $link_url
 * @property string|null $description
 * @property string|null $instructions
 * @property bool $is_enabled
 * @property-read string|null $logo_url
 * @method static Builder|PaymentMethod enabled()
 * @method static Builder|PaymentMethod newModelQuery()
 * @method static Builder|PaymentMethod newQuery()
 * @method static Builder|PaymentMethod query()
 * @method static Builder|PaymentMethod whereCreatedAt($value)
 * @method static Builder|PaymentMethod whereDescription($value)
 * @method static Builder|PaymentMethod whereId($value)
 * @method static Builder|PaymentMethod whereInstructions($value)
 * @method static Builder|PaymentMethod whereIsEnabled($value)
 * @method static Builder|PaymentMethod whereLinkUrl($value)
 * @method static Builder|PaymentMethod whereLogo($value)
 * @method static Builder|PaymentMethod whereSlug($value)
 * @method static Builder|PaymentMethod whereTitle($value)
 * @method static Builder|PaymentMethod whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentMethod extends Model {
    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'logo',
        'link_url',
        'description',
        'instructions',
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['logo_url'];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('payment_methods');
        return 'payment_methods';
    }

    public function getLogoUrlAttribute(): ?string {
        if ($this->logo) {
            return Storage::disk(config('shopper.system.storage.disks.uploads'))->url($this->logo);
        }

        return null;
    }

    public function scopeEnabled(Builder $query): Builder {
        return $query->where('is_enabled', true);
    }
}