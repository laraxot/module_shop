<?php

namespace Modules\Shop\Http\Livewire\Settings\Management;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Shop\Models\User\Role;
use Illuminate\Database\Eloquent\Builder;
use Modules\Shop\Repositories\UserRepository;

class Management extends Component
{
    use WithPagination;

    protected $listeners = ['onRoleAdded' => 'render'];

    public function removeUser(int $id)
    {
        (new UserRepository())->getById($id)->delete();

        $this->dispatchBrowserEvent('user-removed');
        $this->notify([
            'title' => __('Deleted'),
            'message' => __('Admin deleted successfully!'),
        ]);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Shopper\Framework\Exceptions\GeneralException
     */
    public function render()
    {
        return view('shopper::livewire.settings.management.index', [
            'roles' => Role::query()
                ->with('users')
                ->where('name', '<>', config('shopper.system.users.default_role'))
                ->limit(3)
                ->orderBy('created_at')
                ->get(),
            'users' => (new UserRepository())
                ->makeModel()
                ->whereHas('roles', function (Builder $query) {
                    $query->where('name', '<>', config('shopper.system.users.default_role'));
                })
                ->orderBy('created_at', 'desc')
                ->paginate(3),
        ]);
    }
}
