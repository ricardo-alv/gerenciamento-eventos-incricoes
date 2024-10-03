<?php

namespace App\Models\Traits;

use App\Models\Tenant;

trait UserACLTrait
{
    public function isAdmin()
    {
        return in_array($this->email, config('acl.super_admins'));
    }
}
