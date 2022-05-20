<?php

namespace Modules\Shop\Http\Livewire\Reviews;

use Exception;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Modules\Shop\Models\Shop\Review;

class Browse extends Component
{
    /**
     * Defined if a review is approved.
     *
     * @var bool
     */
    public $approved;

    /**
     * Product search name value.
     *
     * @var string
     */
    public $search;

    /**
     * Reset Filter on status.
     */
    public function resetStatusFilter()
    {
        $this->approved = null;
    }

    /**
     * Remove a review from the storage.
     *
     * @throws Exception
     */
    public function remove(int $id)
    {
        Review::query()->find($id)->delete();

        $this->notify([
            'title' => __('Deleted'),
            'message' => __('Review removed successfully.'),
        ]);
        $this->dispatchBrowserEvent('close-review');
    }

    public function render()
    {
        return view('shopper::livewire.reviews.browse', [
            'total' => Review::query()->count(),
            'reviews' => Review::with(['reviewrateable', 'author'])
                ->whereHasMorph('reviewrateable', config('shopper.system.models.product'), function (Builder $query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->where(function (Builder $query) {
                    if ($this->approved !== null) {
                        $query->where('approved', (bool) ($this->approved));
                    }
                })
                ->paginate(8),
        ]);
    }
}
