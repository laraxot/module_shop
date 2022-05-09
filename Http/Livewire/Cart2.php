<?php

declare(strict_types=1);

namespace Modules\Shop\Http\Livewire;

use Illuminate\Contracts\Support\Renderable;
use Livewire\Component;

class Cart2 extends Component {
    public array $result = [];
    public array $cart = [];

    //public $totalPrice = 0;
    public int $productId = 0;
    public array $additions = [];

    public function mount(): void {
        $this->productId = app('request')->input('id');

        $this->result = session()->get('result');
        if (! is_array($this->result)) {
            $this->result = [];
        }
    }

    public function addProduct(float $productPrice, int $quantity): void {
        //$this->totalPrice += $productPrice;

        $this->cart[] = ['id' => $this->productId, 'quantity' => $quantity, 'price' => $productPrice];

        session()->put('result', $this->cart);

        $this->result = session()->get('result');

        redirect()->route('container0.index', ['lang' => \App::getLocale(),
            'container0' => 'product', 'id' => XotModel('product')::find($this->productId)->category_id, ]);
    }

    public function removeProduct(int $productId): void {
        $products = session()->pull('result', []); // Second argument is a default value
        if (false !== ($key = array_search($productId, $products))) {
            unset($products[$key]);
        }
        session()->put('products', $products);
    }

    public function addAdditionId(int $id, int $i): void {
        $this->additions[$i] = $id;
        ++$i;
    }

    public function render(): Renderable {
        $view = 'pub_theme::livewire.buttonAddCart';

        return view()->make($view);
    }
}
