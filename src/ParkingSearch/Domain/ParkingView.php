<?php

namespace App\ParkingSearch\Domain;


class ParkingView
{
    private $id;
    private $name;
    private $owner;
    private $lat;
    private $lng;
    private $street;
    private $number;
    private $postCode;
    private $city;
    private $rate;
    private $openingHours;
    private $priceList;
    private $parkingSpace;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return mixed
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @return mixed
     */
    public function getOpeningHours()
    {
        return json_decode($this->openingHours);
    }

    /**
     * @return mixed
     */
    public function getPriceList()
    {
        return json_decode($this->priceList);
    }

    /**
     * @return mixed
     */
    public function getParkingSpace()
    {
        return json_decode($this->parkingSpace);
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'owner' => $this->getOwner(),
            'street' => $this->getStreet(),
            'number' => $this->getNumber(),
            'postCode' => $this->getPostCode(),
            'city' => $this->getCity(),
            'lat' => $this->getLat(),
            'lng' => $this->getLng(),
            'rate' => $this->getRate(),
            'priceList' => $this->getPriceList(),
            'openingHours' => $this->getOpeningHours(),
            'parkingSpace' => $this->getParkingSpace()
        ];
    }
}