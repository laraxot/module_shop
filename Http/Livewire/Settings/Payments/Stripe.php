<?php

namespace Modules\Shop\Http\Livewire\Settings\Payments;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Modules\Shop\Models\System\Currency;
use Modules\Shop\Models\Shop\PaymentMethod;

class Stripe extends Component
{
    /**
     * Stripe API public key.
     */
    public string $stripe_key = '';

    /**
     * Stripe API secret key.
     */
    public string $stripe_secret = '';

    /**
     * Stripe API Webhook.
     */
    public string $stripe_webhook_secret = '';

    /**
     * Stripe Mode.
     */
    public string $stripe_mode = 'sandbox';

    /**
     * Cashier Currency.
     */
    public string $currency;

    /**
     * Indicates if Stripe Payment is being enabled.
     */
    public bool $enabled = false;

    /**
     * Message display during Stripe installation.
     */
    public string $message = '...';

    public function mount()
    {
        $this->enabled = ($stripe = PaymentMethod::query()->where('slug', 'stripe')->first()) ? $stripe->is_enabled : false;
        $this->stripe_mode = env('STRIPE_MODE', 'sandbox');
        $this->stripe_key = env('STRIPE_KEY', '');
        $this->stripe_secret = env('STRIPE_SECRET', '');
        $this->stripe_webhook_secret = env('STRIPE_WEBHOOK_SECRET', '');
        $this->currency = env('CASHIER_CURRENCY', shopper_currency());
    }

    public function enabledStripe()
    {
        PaymentMethod::query()->create([
            'title' => 'Stripe',
            'link_url' => 'https://laravel.com/docs/billing',
            'is_enabled' => true,
            'description' => "Laravel Cashier provides an expressive, fluent interface to Stripe's subscription billing services. It handles almost all of the boilerplate subscription billing code you are dreading writing. In addition to basic subscription management, Cashier can handle coupons, swapping subscription, subscription 'quantities', cancellation grace periods, and even generate invoice PDFs.",
        ]);

        $this->enabled = true;

        $this->notify([
            'title' => __('Success'),
            'message' => __('You have successfully enabled Stripe payment for your store!'),
        ]);
    }

    public function store()
    {
        setEnvironmentValue([
            'stripe_mode' => $this->stripe_mode,
            'stripe_key' => $this->stripe_key,
            'stripe_secret' => $this->stripe_secret,
            'stripe_webhook_secret' => $this->stripe_webhook_secret,
            'cashier_currency' => $this->currency,
        ]);

        Artisan::call('config:clear');

        $this->notify([
            'title' => __('Updated'),
            'message' => __('Your Stripe payments configuration have been correctly updated!'),
        ]);
    }

    public function render()
    {
        return view('shopper::livewire.settings.payments.stripe', [
            'currencies' => Cache::rememberForever('currencies', fn () => Currency::all()),
        ]);
    }
}
