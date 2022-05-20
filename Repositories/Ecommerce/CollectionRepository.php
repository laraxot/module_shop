<?php

namespace Modules\Shop\Repositories\Ecommerce;

use Modules\Shop\Repositories\BaseRepository;

class CollectionRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     */
    public function model()
    {
        return config('shopper.system.models.collection');
    }
}
