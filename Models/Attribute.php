<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Shop\Models\Traits\HasSlug;

/**
 * Modules\Shop\Models\Attribute
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string|null $slug
 * @property string|null $description
 * @property string $type
 * @property bool $is_enabled
 * @property bool $is_searchable
 * @property bool $is_filterable
 * @property-read string $type_formatted
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Shop\Models\AttributeValue[] $values
 * @property-read int|null $values_count
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereIsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereIsFilterable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereIsSearchable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Attribute extends Model {
    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'is_enabled',
        'is_searchable',
        'is_filterable',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_enabled' => 'boolean',
        'is_searchable' => 'boolean',
        'is_filterable' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'type_formatted',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('attributes');
        return 'attributes';
    }

    /**
     * Return formatted type.
     */
    public function getTypeFormattedAttribute(): string {
        return self::typesFields()[$this->type];
    }

    /**
     * Return available fields types.
     *
     * @return array<string>
     */
    public static function typesFields(): array {
        return [
            'text' => __('Text field :type', ['type' => '(input)']),
            'number' => __('Text field :type', ['type' => '(number)']),
            'richtext' => __('Richtext'),
            'markdown' => __('Markdown'),
            'select' => __('Select'),
            'checkbox' => __('Checkbox'),
            'checkbox_list' => __('Checkbox List'),
            'radio' => __('Radio'),
            // 'toggle' => __('Toggle') ,
            'colorpicker' => __('Color picker'),
            'datepicker' => __('Date picker'),
            // 'file' => __('File') ,
        ];
    }

    /**
     * Return attributes fields that has values by default.
     *
     * @return array<string>
     */
    public static function fieldsWithValues(): array {
        return [
            'select',
            'checkbox',
            'checkbox_list',
            'colorpicker',
            'radio',
        ];
    }

    /**
     * Return attributes fields that has custom string values.
     *
     * @return array<string>
     */
    public static function fieldsWithStringValues(): array {
        return [
            'text',
            'number',
            'richtext',
            'markdown',
            'datepicker',
        ];
    }

    public function values(): HasMany {
        return $this->hasMany(AttributeValue::class);
    }
}