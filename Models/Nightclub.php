<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Geo\Models\Traits\HasPlaceTrait;

/**
 * Modules\Shop\Models\Nightclub.
 */
class Nightclub extends BaseModelLang {
    use HasFactory;
    use HasPlaceTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
