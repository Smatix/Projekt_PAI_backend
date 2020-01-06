<?php

namespace App\Reservation\Application\Command\Finish;

class FinishReservationCommand
{
    /**
     * @var string
     */
    private $id;

    /**
     * FinishReservationCommand constructor.
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