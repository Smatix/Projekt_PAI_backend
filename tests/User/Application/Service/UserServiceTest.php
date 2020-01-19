<?php

namespace App\Tests\User\Application\Service;

use App\User\Application\Service\UserService;
use App\User\Domain\Factory\UserFactory;
use App\User\Domain\Service\PasswordEncoder;
use App\User\Domain\UserStoreRepositoryInterface;
use App\User\Infrastructure\InMemoryUserStoreRepository;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    /**
     * @var UserStoreRepositoryInterface
     */
    private $repository;

    /**
     * @var UserService
     */
    private $service;

    public function setUp()
    {
        parent::setUp();
        $user = $this->createUser();
        $this->repository = new InMemoryUserStoreRepository();
        $this->repository->save($user);
        $this->service = new UserService($this->repository);
    }

    public function createUser()
    {
        $user = UserFactory::create(
            '1234',
            'xyz@wp.pl',
            'Jan',
            'Nowak',
            1
        );
        return $user;
    }

    public function testIfEmailExist()
    {
        $result = $this->service->checkIfEmailExist('xyz@wp.pl');
        $this->assertTrue($result);
    }

    public function testIfEmailNotExist()
    {
        $result = $this->service->checkIfEmailExist('xxx@wp.pl');
        $this->assertFalse($result);
    }

    public function testIfPasswordIsCorrect()
    {
        $result = $this->service->checkIfPasswordIsCorrect('xyz@wp.pl', '1234');
        $this->assertTrue($result);
    }

    public function testIfPasswordIsUncorrect()
    {
        $result = $this->service->checkIfPasswordIsCorrect('xyz@wp.pl', '1111');
        $this->assertFalse($result);
    }
}