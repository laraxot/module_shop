<?php

declare(strict_types=1);

namespace Modules\Shop\Models\Traits;

use Modules\Shop\Models\ItemCat;
use Modules\Shop\Models\ItemCatProduct;

trait HasItemCatTrait {
    /**
     * ------------ RELATIONSHIPS -----------------.
     */
    public function itemCatProducts() {
        $pivot = app(ItemCatProduct::class);
        $pivot_fields = $pivot->getFillable();
        $pivot_table = $pivot->getTable();

        return $this->morphToMany(ItemCat::class, 'post', 'item_cat_product')
            ->using($pivot)
            ->withPivot($pivot_fields)
            ->withTimestamps()
            ->with(['post']) //Eager;
        ;
    }

    //da fare
    public function linkable() {
    }

    /**
     * ------------ SCOPES ------------------------.
     */

    /**
     * Undocumented function
     * $property_id = tag_cat_id
     * $property_value_id = tag_id.
     */
    public function scopeOfItemCat($query, $item_cat_id, $item_cat_product_id) {
        return $query->whereHas(
            'item_cat',
            function ($item) use ($item_cat_product_id): void {
                $item->where('item_cat.id', $item_cat_product_id);
            }
        );
    }
}
