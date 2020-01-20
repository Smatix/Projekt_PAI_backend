<?php

namespace App\Staying\Application\Command\Delete;

class DeleteStayingCommand
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $userId;

    /**
     * DeleteStayingCommand constructor.
     * @param string $id
     * @param string $userId
     */
    public function __construct(string $id, string $userId)
    {
        $this->id = $id;
        $this->userId = $userId;
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
    public function getUserId(): string
    {
        return $this->userId;
    }

}