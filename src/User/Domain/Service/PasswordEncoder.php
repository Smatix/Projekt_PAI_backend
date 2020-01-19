<?php

namespace App\User\Domain\Service;

class PasswordEncoder
{
    public static function encode(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    public static function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}