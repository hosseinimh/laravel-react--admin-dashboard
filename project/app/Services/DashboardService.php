<?php

namespace App\Services;

use App\Services\Service;
use App\Models\User;

class DashboardService extends Service
{
    public function review()
    {
        $items = ['users' => User::getUsersCount()];

        return $this->handleOK(['items' => $items]);
    }
}
