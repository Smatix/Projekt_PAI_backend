<?php

namespace App\User\Domain;


interface UserStoreRepositoryInterface
{
    public function findByEmail(string $email);

    public function save(User $user);
}