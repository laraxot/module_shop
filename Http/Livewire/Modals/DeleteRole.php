<?php

namespace Modules\Shop\Http\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;
use Modules\Shop\Models\User\Role;

class DeleteRole extends ModalComponent
{
    public int $roleId;

    public function mount(int $id)
    {
        $this->roleId = $id;
    }

    public function delete()
    {
        Role::query()->find($this->roleId)->delete();

        session()->flash('success', __('Role deleted successfully.'));

        $this->redirectRoute('shopper.settings.users');
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render()
    {
        return view('shopper::livewire.modals.delete-role');
    }
}
