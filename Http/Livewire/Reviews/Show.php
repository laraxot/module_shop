<?php

namespace Modules\Shop\Http\Livewire\Reviews;

use Exception;
use Livewire\Component;
use Modules\Shop\Models\Shop\Review;

class Show extends Component
{
    /**
     * Review to show.
     */
    public Review $review;

    /**
     * Review approved state.
     */
    public bool $approved;

    /**
     * Component Mount method instance.
     */
    public function mount(Review $review)
    {
        $this->review = $review->load(['reviewrateable', 'author']);
        $this->approved = $review->approved;
    }

    /**
     * Toggle review approved state.
     */
    public function updatedApproved()
    {
        $this->approved = ! $this->review->approved;
        $this->review->update(['approved' => ! $this->review->approved]);

        $this->notify(['title' => __('Updated'), 'message' => __('Review approved status updated.')]);
    }

    /**
     * Remove a review from the storage.
     *
     * @throws Exception
     */
    public function remove()
    {
        $this->review->delete();

        session()->flash('success', __('Review removed successfully.'));
        $this->redirectRoute('shopper.reviews.index');
    }

    public function render()
    {
        return view('shopper::livewire.reviews.show');
    }
}
