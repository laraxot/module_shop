<?php

declare(strict_types=1);

namespace Modules\Shop\Models\Panels\Policies;

use Modules\Xot\Models\Panels\Policies\XotBasePanelPolicy;

class _ModulePanelPolicy extends XotBasePanelPolicy {
    public function migrateFromFood(UserContract $user, PanelContract $panel) {
        return true;
    }
}
