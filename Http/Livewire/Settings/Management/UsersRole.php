<?php

namespace Modules\Shop\Http\Livewire\Settings\Management;

use Livewire\Component;
use Modules\Shop\Models\User\Role;
use Illuminate\Database\Eloquent\Builder;
use Modules\Shop\Repositories\UserRepository;

class UsersRole extends Component
{
    public Role $role;

    public function removeUser(int $id)
    {
        (new UserRepository())->getById($id)->delete();
        $this->dispatchBrowserEvent('user-removed');
        $this->dispatchBrowserEvent('notify', [
            'title' => __('Deleted'),
            'message' => __('Admin deleted successfully'),
        ]);
    }

    public function render()
    {
        $users = (new UserRepository())
            ->makeModel()
            ->whereHas('roles', function (Builder $query) {
                $query->where('name', $this->role->name);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('shopper::livewire.settings.management.users-role', compact('users'));
    }
}
