<?php

namespace Modules\Shop\Models\Traits;

use Modules\Shop\Models\System\File;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Filetable
{
    public function getFirstImage(): ?File
    {
        return $this->files()->first();
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'filetable');
    }
}
