<?php

namespace App\Enums;

class Role
{
    const PIMPINAN = 1;

    const ADMIN = 2;

    const KASIR = 3;

    public static function roleString(int $roleId): string
    {
        $arrayRoles = [
            1 => 'Pimpinan',
            2 => 'Admin',
            3 => 'Kasir',
        ];

        return in_array($roleId, [1,2,3]) ? $arrayRoles[$roleId] : "No role for this role id";
    } 
}
