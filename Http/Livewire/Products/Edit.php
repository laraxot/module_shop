<?php

namespace Modules\Shop\Http\Livewire\Products;

use Livewire\Component;
use Modules\Shop\Repositories\InventoryRepository;
use Modules\Shop\Repositories\Ecommerce\ProductRepository;

class Edit extends Component
{
    /**
     * Product Model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $product;

    /**
     * All locations available on the store.
     */
    public $inventories;

    /**
     * Default inventory id.
     */
    public int $inventory;

    protected $listeners = ['productHasUpdated'];

    /**
     * Component Mount method.
     */
    public function mount($product)
    {
        $this->product = $product;
        $this->inventories = $inventories = (new InventoryRepository())->get();
        $this->inventory = $inventories->where('is_default', true)->first()->id;
    }

    /**
     * Product updated Listener.
     */
    public function productHasUpdated(int $id)
    {
        $this->product = (new ProductRepository())->getById($id);
    }

    public function render()
    {
        return view('shopper::livewire.products.edit', [
            'currency' => shopper_currency(),
        ]);
    }
}
