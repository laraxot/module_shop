<?php

namespace Modules\Shop\Models\Traits;

use Modules\Shop\Models\Shop\DiscountDetail;
use Illuminate\Database\Eloquent\Relations\morphMany;

trait CanHaveDiscount
{
    public function discounts(): morphMany
    {
        return $this->morphMany(DiscountDetail::class, 'discountable')->orderBy('created_at', 'desc');
    }
}
