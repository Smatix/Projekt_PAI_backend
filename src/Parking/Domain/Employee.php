<?php

namespace App\Parking\Domain;


class Employee
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var Parking
     */
    private $parking;

    /**
     * Employee constructor.
     * @param string $userId
     */
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param Parking $parking
     */
    public function setParking(Parking $parking): void
    {
        $this->parking = $parking;
    }


}