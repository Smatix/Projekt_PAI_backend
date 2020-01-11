<?php

namespace App\Staying\Application\Command\Active;


class ActiveStayingCommand
{
    /**
     * @var string
     */
    private $id;

    /**
     * FinishStayingCommand constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}