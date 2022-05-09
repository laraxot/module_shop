<?php

namespace Modules\Shop\Http\Livewire\Modals;

use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use LivewireUI\Modal\ModalComponent;
use Modules\Shop\Models\Shop\PaymentMethod;

class UpdatePaymentMethod extends ModalComponent
{
    use WithFileUploads;

    public PaymentMethod $paymentMethod;

    public string $title = '';

    public ?string $linkUrl = null;

    public ?string $description = null;

    public ?string $instructions = null;

    public ?string $logoUrl;

    public $logo;

    public function mount(int $id)
    {
        $this->paymentMethod = $paymentMethod = PaymentMethod::find($id);
        $this->title = $paymentMethod->title;
        $this->description = $paymentMethod->description;
        $this->linkUrl = $paymentMethod->link_url;
        $this->instructions = $paymentMethod->instructions;
        $this->logoUrl = $paymentMethod->logo_url;
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function save()
    {
        $this->validate([
            'title' => [
                'required',
                Rule::unique(shopper_table('payment_methods'), 'title')->ignore($this->paymentMethod->id),
            ],
            'logo' => 'nullable|image|max:1024',
        ]);

        $this->paymentMethod->update([
            'title' => $this->title,
            'link_url' => $this->linkUrl,
            'description' => $this->description,
            'instructions' => $this->instructions,
        ]);

        if ($this->logo) {
            $this->paymentMethod->update([
                'logo' => $this->logo->store('/', config('shopper.system.storage.disks.uploads')),
            ]);
        }

        $this->notify([
            'title' => __('Update'),
            'message' => __('Your payment method have been correctly updated.'),
        ]);

        $this->emit('onPaymentMethodAdded');

        $this->closeModal();
    }

    public function render()
    {
        return view('shopper::livewire.modals.update-payment-method');
    }
}
