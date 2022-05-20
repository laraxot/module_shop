<?php

namespace Modules\Shop\Repositories;

use Modules\Shop\Models\User\User;

class UserRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     */
    public function model()
    {
        return config('auth.providers.users.model', User::class);
    }
}
