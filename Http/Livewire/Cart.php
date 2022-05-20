<?php

declare(strict_types=1);

namespace Modules\Shop\Http\Livewire;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Cart extends Component {
    public Model $row;

    public array $cart = [];

    public array $single_product = ['id' => '', 'title' => '', 'price' => '', 'txt' => ''];

    public string $product;

    /*
     * Undocumented function.
     *
     * @return void
     */

    public function mount(Model $row):void {
        $this->row = $row;
        //$this->cart = session()->get('cart'); //se commento il cart si azzera al refresh
        if (! is_array($this->cart)) {
            $this->cart = [];
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    /**
     * Render the component.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function render():Renderable {
        // first view vedi laravel per utilizzare eventualmente la grafica del tema(?)
        $view = 'shop::livewire.cart';

        //da spostare in futuro per la prestazione
        $cart_total = collect($this->cart)
            ->sum(
                function ($product) {
                    return $product['price'] * $product['qty'];
                }
            );
        $cart_count = collect($this->cart)
            ->sum(
                function ($product) {
                    return $product['qty'];
                }
            );
        $view_params = [
            'view' => $view,
            'rows' => $this->row->getAttribute('products'),
            'cart_total' => $cart_total,
            'cart_count' => $cart_count,
            'test' => now(),
            'product' => $this->product,
        ];

        return view()->make($view, $view_params);
    }

    public function showProduct(int $id, string $title, float $price, string $txt): void {
        //dddx($txt);
        $this->single_product['id'] = $id;
        $this->single_product['title'] = $title;
        $this->single_product['price'] = $price;
        $this->single_product['txt'] = $txt;
    }

    public function addToCart(int $product_id, string $product_title, float $product_price): void {
        //controllo che l'articolo aggiunto non sia già stato inserito nel carrello
        $is_in_array = false;
        foreach ($this->cart as $key => $item) {
            if ($item['id'] == $product_id && $item['price'] == $product_price) {
                ++$this->cart[$key]['qty'];
                $is_in_array = true;
            }
        }
        //nel caso non ci sia, aggiungo nel carrello
        if (false == $is_in_array) {
            $this->cart[] = [
                'id' => $product_id,
                'title' => $product_title,
                'price' => $product_price,
                'qty' => '1',
            ];
        }

        session()->put('cart', $this->cart);
    }

    /**
     * Undocumented function.
     *
     * @return void
     */
    public function updateCart() {
        session()->put('cart', $this->cart);
    }

    public function removeToCart(int $cart_element_id): void {
        unset($this->cart[$cart_element_id]);
    }
}
