<?php

declare(strict_types=1);

namespace Modules\Shop\Models\Panels;

use Modules\Xot\Models\Panels\XotBasePanel;

/**
 * Class _ModulePanel.
 */
class _ModulePanel extends XotBasePanel {
    public function actions(): array {
        return [
            new Actions\MigrateFromFoodAction(), //si fa in admin percio _ModulePanel
        ];
    }
}
