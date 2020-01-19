<?php

namespace App\User\Application\Service;

use App\User\Domain\Service\PasswordEncoder;
use App\User\Domain\User;
use App\User\Domain\UserStoreRepositoryInterface;

class UserService
{
    /**
     * @var UserStoreRepositoryInterface
     */
    private $userStoreRepository;

    /**
     * UserService constructor.
     * @param UserStoreRepositoryInterface $userStoreRepository
     */
    public function __construct(UserStoreRepositoryInterface $userStoreRepository)
    {
        $this->userStoreRepository = $userStoreRepository;
    }


    public function checkIfEmailExist(string $email)
    {
        /** @var User $user */
        $user = $this->userStoreRepository->findByEmail($email);
        if(!$user) {
            return false;
        }
        return true;
    }

    public function checkIfPasswordIsCorrect($email, $plainPassword)
    {
        /** @var User $user */
        $user = $this->userStoreRepository->findByEmail($email);
        return PasswordEncoder::verify($plainPassword, $user->getPassword());
    }
}