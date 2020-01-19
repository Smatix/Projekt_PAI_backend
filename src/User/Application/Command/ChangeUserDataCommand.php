<?php

namespace App\User\Application\Command;


class ChangeUserDataCommand
{
    /**
     * @var string
     */
    private $newEmail;

    /**
     * @var string | null
     */
    private $oldEmail;

    /**
     * @var string | null
     */
    private $newPassword;

    /**
     * @var string | null
     */
    private $oldPassword;

    /**
     * @return string | null
     */
    public function getNewEmail(): ?string
    {
        return $this->newEmail;
    }

    /**
     * @param string $newEmail
     */
    public function setNewEmail(string $newEmail): void
    {
        $this->newEmail = $newEmail;
    }

    /**
     * @return string | null
     */
    public function getOldEmail(): ?string
    {
        return $this->oldEmail;
    }

    /**
     * @param string $oldEmail
     */
    public function setOldEmail(string $oldEmail): void
    {
        $this->oldEmail = $oldEmail;
    }

    /**
     * @return string | null
     */
    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    /**
     * @param string $newPassword
     */
    public function setNewPassword(string $newPassword): void
    {
        $this->newPassword = $newPassword;
    }

    /**
     * @return string | null
     */
    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    /**
     * @param string $oldPassword
     */
    public function setOldPassword(string $oldPassword): void
    {
        $this->oldPassword = $oldPassword;
    }


}