<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 21.12.2019
 * Time: 18:13
 */

namespace App\User\Domain\Factory;


use App\Shared\Infrastructure\Uuid\RamseyUuidAdapter;
use App\User\Domain\User;

class UserFactory
{
    public static function create(
        string $username,
        string $password,
        string $email,
        string $name,
        string $surname)
    {
        return new User(
            RamseyUuidAdapter::generate(),
            $username,
            password_hash($password, PASSWORD_BCRYPT),
            $email,
            $name,
            $surname,
            ['ROLE_USER']
        );
    }
}