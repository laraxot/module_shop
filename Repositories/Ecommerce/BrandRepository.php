<?php

namespace Modules\Shop\Repositories\Ecommerce;

use Modules\Shop\Repositories\BaseRepository;

class BrandRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     */
    public function model()
    {
        return config('shopper.system.models.brand');
    }
}
