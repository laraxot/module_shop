<?php
namespace Modules\Shop\Models\Panels\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\LU\Models\User as User;
use Modules\Shop\Models\Panels\Policies\ShopCatPanelPolicy as Panel;

use Modules\Xot\Models\Panels\Policies\XotBasePanelPolicy;

class ShopCatPanelPolicy extends XotBasePanelPolicy {
}
