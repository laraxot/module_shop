<?php

namespace Modules\Shop\Models\Traits;

use Modules\Shop\Models\InventoryHistory;
use Illuminate\Database\Eloquent\Relations\morphMany;

trait ReferencedByInventoryHistories
{
    public function stockMutations(): morphMany
    {
        return $this->morphMany(InventoryHistory::class, 'reference');
    }
}
