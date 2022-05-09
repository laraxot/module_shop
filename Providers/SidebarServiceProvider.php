<?php

namespace Modules\Shop\Providers;

use Illuminate\Support\ServiceProvider;
use Maatwebsite\Sidebar\SidebarManager;
use Modules\Shop\Sidebar\AdminSidebar;

class SidebarServiceProvider extends ServiceProvider
{
    /**
     * Sidebar Manager.
     */
    public function boot(SidebarManager $manager)
    {
        $manager->register(AdminSidebar::class);
    }
}
