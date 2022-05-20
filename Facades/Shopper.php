<?php

namespace Modules\Shop\Facades;

use Illuminate\Support\Facades\Facade;

class Shopper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'shopper';
    }
}
