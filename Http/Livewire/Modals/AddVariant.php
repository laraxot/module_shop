<?php

namespace Modules\Shop\Http\Livewire\Modals;

use function count;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Modules\Shop\Traits\WithUploadProcess;
use Modules\Shop\Repositories\InventoryRepository;
use Modules\Shop\Http\Livewire\Products\WithAttributes;
use Modules\Shop\Repositories\Ecommerce\ProductRepository;

class AddVariant extends ModalComponent
{
    use WithFileUploads;
    use WithAttributes;
    use WithUploadProcess;

    public int $productId;

    public string $currency;

    /**
     * Default product stock quantity.
     */
    public $quantity;

    public function mount(int $productId, string $currency)
    {
        $this->productId = $productId;
        $this->currency = $currency;
    }

    public function save()
    {
        $this->validate($this->rules());

        $product = (new ProductRepository())->create([
            'name' => $this->name,
            'slug' => $this->name,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'is_visible' => true,
            'security_stock' => $this->securityStock,
            'old_price_amount' => $this->old_price_amount,
            'price_amount' => $this->price_amount,
            'cost_amount' => $this->cost_amount,
            'parent_id' => $this->productId,
        ]);

        if ($this->file) {
            $this->uploadFile(config('shopper.system.models.product'), $this->productId);
        }

        if ($this->quantity && count($this->quantity) > 0) {
            foreach ($this->quantity as $inventory => $value) {
                $product->mutateStock(
                    $inventory,
                    $value,
                    [
                        'event' => __('Initial inventory'),
                        'old_quantity' => $value,
                    ]
                );
            }
        }

        $this->notify([
            'title' => __('Added'),
            'message' => __('Product variation successfully added!'),
        ]);

        $this->emit('onVariantAdded');

        $this->closeModal();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:' . shopper_table('products'),
            'sku' => 'nullable|unique:' . shopper_table('products'),
            'barcode' => 'nullable|unique:' . shopper_table('products'),
            'file' => 'nullable|image|max:1024',
        ];
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function render()
    {
        return view('shopper::livewire.modals.add-variant', [
            'inventories' => (new InventoryRepository())->get(),
        ]);
    }
}
