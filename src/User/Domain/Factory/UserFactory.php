<?php

namespace App\User\Domain\Factory;

use App\Shared\Infrastructure\Uuid\RamseyUuidAdapter;
use App\User\Domain\Service\PasswordEncoder;
use App\User\Domain\User;

class UserFactory
{
    public static function create(
        string $password,
        string $email,
        string $name,
        string $surname,
        int $role)
    {
        return new User(
            RamseyUuidAdapter::generate(),
            PasswordEncoder::encode($password),
            $email,
            $name,
            $surname,
            self::getRole($role)
        );
    }

    private static function getRole(int $role)
    {
        $roles = [];
        if($role > 0) $roles[] = 'ROLE_USER';
        if($role > 1) $roles[] = 'ROLE_EMPLOYEE';
        if($role > 2) $roles[] = 'ROLE_OWNER';
        return $roles;
    }
}