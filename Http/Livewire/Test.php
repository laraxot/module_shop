<?php

declare(strict_types=1);

namespace Modules\Shop\Http\Livewire;

use Illuminate\Contracts\Support\Renderable;
use Livewire\Component;

class Test extends Component {
    /**
     * Undocumented function.
     */
    public function mount(): void {
    }

    public function render(): Renderable {
        return view()->make('shop::livewire.test');
    }
}
