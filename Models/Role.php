<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Modules\Shop\Models\Role
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @mixin \Eloquent
 */
class Role extends SpatieRole {
    protected $fillable=[''];

    public function isAdmin(): bool {
        return $this->name === config('shopper.system.users.admin_role');
    }
}