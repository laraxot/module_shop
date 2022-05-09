<?php

declare(strict_types=1);

namespace Modules\Shop\Models\Panels\Policies;

use Modules\Xot\Contracts\PanelContract;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Panels\Policies\XotBasePanelPolicy;

class HomePanelPolicy extends XotBasePanelPolicy {
    public function artisan(?UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function migrateFromFood(UserContract $user, PanelContract $panel): bool {
        return true;
    }

    public function home(?UserContract $user, PanelContract $panel): bool {
        return true;
    }
}
