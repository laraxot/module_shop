<?php

namespace Modules\Shop\Http\Livewire\Settings\Mails;

use Livewire\Component;
use Modules\Shop\Services\Mailable;

class AddTemplate extends Component
{
    public function render()
    {
        return view('shopper::livewire.settings.mails.templates.add-template', [
            'skeletons' => Mailable::getTemplateSkeletons(),
        ]);
    }
}
