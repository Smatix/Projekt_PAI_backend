<?php

namespace App\User\Application\Command;

use App\User\Domain\Service\PasswordEncoder;
use App\User\Domain\User;
use App\User\Domain\UserStoreRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ChangeUserDataHandler implements MessageHandlerInterface
{
    /**
     * @var UserStoreRepositoryInterface
     */
    private $repository;

    /**
     * RegisterUserHandler constructor.
     * @param UserStoreRepositoryInterface $repository
     */
    public function __construct(UserStoreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ChangeUserDataCommand $command)
    {
        /** @var User $user */
        $user = $this->repository->findByEmail($command->getOldEmail());
        if (PasswordEncoder::verify($command->getOldPassword(), $user->getPassword())) {
            $user->changeEmailAndPassword($command->getNewEmail(), $command->getNewPassword());
            $this->repository->save($user);
        }
    }
}