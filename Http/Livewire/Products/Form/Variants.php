<?php

namespace Modules\Shop\Http\Livewire\Products\Form;

use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Database\Eloquent\Builder;
use Modules\Shop\Traits\WithSorting;
use Modules\Shop\Traits\WithUploadProcess;
use Modules\Shop\Events\Products\ProductRemoved;
use Modules\Shop\Http\Livewire\Products\WithAttributes;
use Modules\Shop\Repositories\Ecommerce\ProductRepository;

class Variants extends Component
{
    use WithPagination;
    use WithFileUploads;
    use WithSorting;
    use WithAttributes;
    use WithUploadProcess;

    public string $search = '';

    /**
     * Default product stock quantity.
     */
    public $quantity;

    /**
     * Product Model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $product;

    public string $currency;

    protected $listeners = ['onVariantAdded' => 'render'];

    /**
     * Component mount instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $product
     */
    public function mount($product, string $currency)
    {
        $this->product = $product;
        $this->currency = $currency;
    }

    public function paginationView(): string
    {
        return 'shopper::livewire.wire-pagination-links';
    }

    /**
     * Remove a record to the database.
     *
     * @throws Exception
     */
    public function remove(int $id)
    {
        $product = (new ProductRepository())->getById($id);

        event(new ProductRemoved($product));

        $product->forceDelete();

        $this->dispatchBrowserEvent('item-removed');

        $this->notify([
            'title' => __('Deleted'),
            'message' => __('The variation has successfully removed!'),
        ]);
    }

    public function render()
    {
        return view('shopper::livewire.products.forms.form-variants', [
            'variants' => (new ProductRepository())
                ->makeModel()
                ->where(function (Builder $query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                    $query->where('parent_id', $this->product->id);
                })
                ->orderBy($this->sortBy ?? 'name', $this->sortDirection)
                ->paginate(10),
        ]);
    }
}
