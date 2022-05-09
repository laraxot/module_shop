<?php

namespace Modules\Shop\Http\Livewire\Settings\Inventories;

use Modules\Shop\Rules\Phone;
use Modules\Shop\Models\System\Country;
use Modules\Shop\Models\Shop\Inventory\Inventory;
use Modules\Shop\Http\Livewire\AbstractBaseComponent;

class Create extends AbstractBaseComponent
{
    public string $name = '';

    public ?string $description = null;

    public string $email = '';

    public string $city = '';

    public string $street_address = '';

    public ?string $street_address_plus = null;

    public ?string $zipcode = null;

    public ?string $phone_number = null;

    public ?int $country_id = null;

    /**
     * Define if the inventory is the default.
     */
    public bool $isDefault = false;

    /**
     * Store/Update a entry to the storage.
     */
    public function store()
    {
        $this->validate($this->rules());

        Inventory::query()->create([
            'name' => $this->name,
            'code' => str_slug($this->name),
            'email' => $this->email,
            'city' => $this->city,
            'description' => $this->description,
            'street_address' => $this->street_address,
            'street_address_plus' => $this->street_address_plus,
            'zipcode' => $this->zipcode,
            'phone_number' => $this->phone_number,
            'country_id' => $this->country_id,
            'is_default' => $this->isDefault,
        ]);

        session()->flash('success', __('Inventory Successfully Added.'));

        $this->redirectRoute('shopper.settings.inventories.index');
    }

    public function render()
    {
        return view('shopper::livewire.settings.inventories.create', [
            'countries' => Country::select('name', 'id')->orderBy('name')->get(),
        ]);
    }

    protected function rules(): array
    {
        return [
            'email' => 'required|email|unique:' . shopper_table('inventories'),
            'name' => 'required|max:100',
            'city' => 'required',
            'street_address' => 'required',
            'zipcode' => 'required',
            'phone_number' => ['nullable', new Phone()],
            'country_id' => 'required|exists:' . shopper_table('system_countries') . ',id',
        ];
    }
}
