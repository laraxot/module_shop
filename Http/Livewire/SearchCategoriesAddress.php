<?php

declare(strict_types=1);

namespace Modules\Shop\Http\Livewire;

use Illuminate\Contracts\Support\Renderable;
use Livewire\Component;

class SearchCategoriesAddress extends Component {

    public bool $show_categories;

    public function mount(){
        $this->show_categories=false;
    }

    public function showCategories($locality){
        $this->show_categories=true;
        $this->locality=$locality;

        
    }

    public function render(): Renderable {

        $view = 'shop::livewire.search_categories_address';

        return view()->make($view);
    }

}
