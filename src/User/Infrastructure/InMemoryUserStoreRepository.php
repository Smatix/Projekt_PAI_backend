<?php

namespace App\User\Infrastructure;

use App\User\Domain\User;
use App\User\Domain\UserStoreRepositoryInterface;

class InMemoryUserStoreRepository implements UserStoreRepositoryInterface
{
    /**
     * @var array
     */
    private $users = [];

    public function findByEmail(string $email)
    {
        /** @var User $user */
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }
        return null;
    }

    public function save(User $user)
    {
        $this->users[] = $user;
    }

}