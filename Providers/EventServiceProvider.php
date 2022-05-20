<?php

namespace Modules\Shop\Providers;

use Modules\Shop\Events\Products\ProductCreated;
use Modules\Shop\Events\Products\ProductRemoved;
use Modules\Shop\Events\Products\ProductUpdated;
use Modules\Shop\Listeners\Products\CreateProductSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ProductCreated::class => [
            CreateProductSubscriber::class,
        ],

        ProductUpdated::class => [],

        ProductRemoved::class => [],
    ];
}
