<?php

namespace Modules\Shop\Repositories;

use Modules\Shop\Models\Shop\Inventory\Inventory;

class InventoryRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     */
    public function model()
    {
        return Inventory::class;
    }
}
