<?php

namespace Modules\Shop\Traits;

use Exception;
use Modules\Shop\Models\System\File;

trait WithUploadProcess
{
    /**
     * Upload file.
     *
     * @var \Illuminate\Http\UploadedFile
     */
    public $file;

    /**
     * Remove file.
     */
    public function removeImage()
    {
        $this->file = null;
    }

    /**
     * Removed file from the database.
     *
     * @throws Exception
     */
    public function deleteImage(int $id)
    {
        File::query()->find($id)->delete();

        $this->emitSelf('fileDeleted');

        $this->notify([
            'title' => __('Removed'),
            'message' => __('Image removed from the storage.'),
        ]);
    }

    /**
     * Upload file and associate with the current model.
     */
    public function uploadFile(string $model, int $id)
    {
        File::query()->create([
            'disk_name' => $filename = $this->file->store('/', config('shopper.system.storage.disks.uploads')),
            'file_name' => $this->file->getClientOriginalName(),
            'file_size' => $this->file->getSize(),
            'content_type' => $this->file->getClientMimeType(),
            'filetable_type' => $model,
            'filetable_id' => $id,
        ]);
    }
}
