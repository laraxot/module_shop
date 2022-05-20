<?php

namespace Modules\Shop\Http\Livewire\Brands;

use Livewire\WithFileUploads;
use Modules\Shop\Traits\WithUploadProcess;
use Modules\Shop\Http\Livewire\AbstractBaseComponent;
use Modules\Shop\Repositories\Ecommerce\BrandRepository;

class Create extends AbstractBaseComponent
{
    use WithFileUploads;
    use WithUploadProcess;

    public string $name = '';

    public string $slug;

    public ?string $website = null;

    public ?string $description = null;

    public bool $is_enabled = true;

    public function store(): void
    {
        $this->validate($this->rules());

        $brand = (new BrandRepository())->create([
            'name' => $this->name,
            'slug' => $this->name,
            'website' => $this->website,
            'description' => $this->description,
            'is_enabled' => $this->is_enabled,
        ]);

        if ($this->file) {
            $this->uploadFile(config('shopper.system.models.brand'), $brand->id);
        }

        session()->flash('success', __('Brand successfully added!'));

        $this->redirectRoute('shopper.brands.index');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:150|unique:' . shopper_table('brands'),
            'file' => 'nullable|image|max:1024',
        ];
    }

    public function render()
    {
        return view('shopper::livewire.brands.create');
    }
}
