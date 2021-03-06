<?php

namespace Modules\Shop\Http\Livewire\Settings\Inventories;

use Livewire\Component;
use Modules\Shop\Models\Shop\Inventory\Inventory;

class Browse extends Component
{
    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('shopper::livewire.settings.inventories.browse', [
            'inventories' => Inventory::query()->with('country')->get()->take(4),
        ]);
    }
}
