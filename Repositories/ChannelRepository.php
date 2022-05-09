<?php

namespace Modules\Shop\Repositories;

use Modules\Shop\Models\Shop\Channel;

class ChannelRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     */
    public function model()
    {
        return Channel::class;
    }
}
