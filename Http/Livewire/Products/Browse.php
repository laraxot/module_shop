<?php

namespace Modules\Shop\Http\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Modules\Shop\Traits\WithSorting;
use Modules\Shop\Events\Products\ProductRemoved;
use Modules\Shop\Repositories\Ecommerce\BrandRepository;
use Modules\Shop\Repositories\Ecommerce\ProductRepository;
use Modules\Shop\Repositories\Ecommerce\CategoryRepository;
use Modules\Shop\Repositories\Ecommerce\CollectionRepository;

class Browse extends Component
{
    use WithPagination;
    use WithSorting;

    public string $search = '';

    public ?string $isVisible = null;

    public ?int $brand_id = null;

    public ?int $category_id = null;

    public ?int $collection_id = null;

    public function paginationView(): string
    {
        return 'shopper::livewire.wire-pagination-links';
    }

    public function resetStatusFilter(): void
    {
        $this->isVisible = null;
    }

    public function remove(int $id)
    {
        $product = (new ProductRepository())->getById($id);

        event(new ProductRemoved($product));

        $product->delete();

        $this->dispatchBrowserEvent('item-removed');

        $this->notify([
            'title' => __('Deleted'),
            'message' => __('The product has successfully removed!'),
        ]);
    }

    public function render()
    {
        return view('shopper::livewire.products.browse', [
            'total' => (new ProductRepository())->count(),
            'brands' => (new BrandRepository())->makeModel()->scopes('enabled')->select('name', 'id')->get(),
            'categories' => (new CategoryRepository())->makeModel()->scopes('enabled')->select('name', 'id')->get(),
            'collections' => (new CollectionRepository())->get(['name', 'id']),
            'products' => (new ProductRepository())
                ->makeModel()
                ->with(['brand', 'variations'])
                ->withCount(['variations'])
                ->where(function (Builder $query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                    $query->where('parent_id', null);
                })
                ->where(function (Builder $query) {
                    if ($this->brand_id) {
                        $query->where('brand_id', $this->brand_id);
                    }

                    if ($this->collection_id) {
                        $query->whereHas('collections', function (Builder $q) {
                            $q->whereIn('id', [$this->collection_id]);
                        });
                    }

                    if ($this->category_id) {
                        $query->whereHas('categories', function (Builder $q) {
                            $q->whereIn('id', [$this->category_id]);
                        });
                    }
                })
                ->where(function (Builder $query) {
                    if ($this->isVisible !== null) {
                        $query->where('is_visible', (bool) ($this->isVisible));
                    }
                })
                ->orderBy($this->sortBy ?? 'name', $this->sortDirection)
                ->paginate(10),
        ]);
    }
}
