<?php

namespace App\Enums;

enum RoleEnum: int
{
    case ADMIN = 1;
    case SUBADMIN = 2;

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Admin',
            self::SUBADMIN => 'Sub-Admin',
        };
    }
}
