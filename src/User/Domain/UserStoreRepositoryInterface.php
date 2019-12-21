<?php

namespace App\User\Domain;


interface UserStoreRepositoryInterface
{
    public function findByUsername(string $username);

    public function save(User $user);
}