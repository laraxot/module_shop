<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Shop\Models\User\Role;

class SettingController extends Controller
{
    public function initialize()
    {
        return view('shopper::pages.settings.initialize');
    }

    public function role(Role $role)
    {
        return view('shopper::pages.settings.management.role', compact('role'));
    }
}
