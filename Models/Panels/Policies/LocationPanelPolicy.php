<?php
namespace Modules\Shop\Models\Panels\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\LU\Models\User as User;
use Modules\Shop\Models\Panels\Policies\LocationPanelPolicy as Panel;

use Modules\Xot\Models\Panels\Policies\XotBasePanelPolicy;

class LocationPanelPolicy extends XotBasePanelPolicy {
}
