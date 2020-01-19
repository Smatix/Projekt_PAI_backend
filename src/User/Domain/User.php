<?php

namespace App\User\Domain;

use App\User\Domain\Service\PasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var array
     */
    private $roles = [];

    /**
     * User constructor.
     * @param string $id
     * @param string $password
     * @param string $email
     * @param string $name
     * @param string $surname
     * @param array $roles
     */
    public function __construct(
        string $id,
        string $password,
        string $email,
        string $name,
        string $surname,
        array $roles
    )
    {
        $this->id = $id;
        $this->password = $password;
        $this->email = $email;
        $this->name = $name;
        $this->surname = $surname;
        $this->roles = $roles;
    }


    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }

    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function changeEmailAndPassword($email, $newPassword)
    {
        $this->password = PasswordEncoder::encode($newPassword);
        $this->email = $email;
    }
}