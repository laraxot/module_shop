<?php

namespace Modules\Shop\Http\Livewire\Brands;

use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Modules\Shop\Models\System\File;
use Modules\Shop\Traits\WithUploadProcess;
use Modules\Shop\Http\Livewire\AbstractBaseComponent;

class Edit extends AbstractBaseComponent
{
    use WithFileUploads;
    use WithUploadProcess;

    public $brand;

    public int $brand_id;

    public string $name;

    public ?string $website = null;

    public ?string $description = null;

    /**
     * Indicates if brand is being enabled.
     */
    public bool $is_enabled = false;

    protected $listeners = ['fileDeleted'];

    /**
     * Component mount instance.
     */
    public function mount($brand)
    {
        $this->brand = $brand;
        $this->brand_id = $brand->id;
        $this->name = $brand->name;
        $this->website = $brand->website;
        $this->description = $brand->description;
        $this->is_enabled = $brand->is_enabled;
    }

    public function store(): void
    {
        $this->validate($this->rules());

        $this->brand->update([
            'name' => $this->name,
            'slug' => $this->name,
            'website' => $this->website,
            'description' => $this->description,
            'is_enabled' => $this->is_enabled,
        ]);

        if ($this->file) {
            if ($this->brand->files->isNotEmpty()) {
                foreach ($this->brand->files as $file) {
                    Storage::disk(config('shopper.system.storage.disks.uploads'))->delete($file->disk_name);
                }
                File::query()->where('filetable_id', $this->brand_id)->delete();
            }

            $this->uploadFile(config('shopper.system.models.brand'), $this->brand->id);
        }

        session()->flash('success', __('Brand successfully updated!'));

        $this->redirectRoute('shopper.brands.index');
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:150',
                Rule::unique(shopper_table('brands'), 'name')->ignore($this->brand_id),
            ],
            'file' => 'nullable|image|max:1024',
        ];
    }

    /**
     * Listen when a file is removed from the storage
     * and update the user screen and remove image preview.
     */
    public function fileDeleted()
    {
        $this->media = null;
    }

    public function render()
    {
        return view('shopper::livewire.brands.edit', [
            'media' => $this->brand->files->isNotEmpty()
                ? $this->brand->files->first()
                : null,
        ]);
    }
}
