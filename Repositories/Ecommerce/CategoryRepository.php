<?php

namespace Modules\Shop\Repositories\Ecommerce;

use Modules\Shop\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     */
    public function model()
    {
        return config('shopper.system.models.category');
    }
}
