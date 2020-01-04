<?php

namespace App\Reservation\Application\Command\Accept;

class AcceptReservationCommand
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