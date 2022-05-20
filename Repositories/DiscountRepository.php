<?php

namespace Modules\Shop\Repositories;

use Modules\Shop\Models\Shop\Discount;

class DiscountRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     */
    public function model()
    {
        return Discount::class;
    }
}
