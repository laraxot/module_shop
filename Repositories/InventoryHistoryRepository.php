<?php

namespace Modules\Shop\Repositories;

use Modules\Shop\Models\Shop\Inventory\InventoryHistory;

class InventoryHistoryRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     */
    public function model()
    {
        return InventoryHistory::class;
    }
}
