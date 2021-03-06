<?php

namespace Modules\Shop\Http\Livewire\Collections;

use Carbon\Carbon;
use function count;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Shop\Traits\WithConditions;
use Modules\Shop\Traits\WithSeoAttributes;
use Modules\Shop\Traits\WithUploadProcess;
use Modules\Shop\Models\Shop\Product\CollectionRule;
use Modules\Shop\Repositories\Ecommerce\CollectionRepository;

class Create extends Component
{
    use WithFileUploads;
    use WithUploadProcess;
    use WithConditions;
    use WithSeoAttributes;

    /**
     * Collection name.
     *
     * @var string
     */
    public $name;

    /**
     * Collection sample description.
     *
     * @var string
     */
    public $description;

    /**
     * Type of collection that's be created.
     *
     * @var string
     */
    public $type = 'auto';

    /**
     * Publish date for the collection.
     *
     * @var string
     */
    public $publishedAt;

    /**
     * Formatted publishedAt date.
     *
     * @var string
     */
    public $publishedAtFormatted;

    /**
     * The condition apply to the product of the collection.
     *
     * @var string
     */
    public $condition_match = 'all';

    /**
     * Live updated Formatted publishedAt attribute.
     */
    public function updatedPublishedAt()
    {
        $this->publishedAtFormatted = Carbon::createFromFormat('Y-m-d', $this->publishedAt)->toRfc7231String();
    }

    /**
     * Save new entry to the database.
     */
    public function store()
    {
        $this->validate($this->rules());

        $collection = (new CollectionRepository())->create([
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'match_conditions' => $this->condition_match,
            'seo_title' => $this->seoTitle,
            'seo_description' => $this->seoDescription,
            'published_at' => $this->publishedAt ?? now(),
        ]);

        if ($this->file) {
            $this->uploadFile(config('shopper.system.models.collection'), $collection->id);
        }

        if ($this->type === 'auto' && count($this->conditions) > 0 && $this->rule) {
            foreach ($this->rule as $key => $value) {
                CollectionRule::query()->create([
                    'collection_id' => $collection->id,
                    'rule' => $this->rule[$key],
                    'operator' => $this->operator[$key],
                    'value' => $this->value[$key],
                ]);
            }

            $this->conditions = [];
            $this->resetConditionsFields();
        }

        session()->flash('success', __('Collection successfully added!'));

        $this->redirectRoute('shopper.collections.edit', $collection);
    }

    /**
     * Component validation rules.
     *
     * @return array<string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:150|unique:' . shopper_table('collections'),
            'file' => 'nullable|image|max:1024',
            'type' => 'required',
        ];
    }

    public function render()
    {
        return view('shopper::livewire.collections.create');
    }
}
