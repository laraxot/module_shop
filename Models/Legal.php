<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Shop\Models\Traits\HasSlug;

/**
 * Modules\Shop\Models\Legal
 *
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property string|null $content
 * @property bool $is_enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Legal enabled()
 * @method static Builder|Legal newModelQuery()
 * @method static Builder|Legal newQuery()
 * @method static Builder|Legal query()
 * @method static Builder|Legal whereContent($value)
 * @method static Builder|Legal whereCreatedAt($value)
 * @method static Builder|Legal whereId($value)
 * @method static Builder|Legal whereIsEnabled($value)
 * @method static Builder|Legal whereSlug($value)
 * @method static Builder|Legal whereTitle($value)
 * @method static Builder|Legal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Legal extends Model {
    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
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
        //return shopper_table('legals');

        return 'legals';
    }

    public function scopeEnabled(Builder $query): Builder {
        return $query->where('is_enabled', true);
    }
}