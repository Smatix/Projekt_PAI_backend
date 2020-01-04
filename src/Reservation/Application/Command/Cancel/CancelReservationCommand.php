<?php

namespace App\Reservation\Application\Command\Cancel;

class CancelReservationCommand
{
    /**
     * @var string
     */
    private $id;

    /**
     * CancelReservationCommand constructor.
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