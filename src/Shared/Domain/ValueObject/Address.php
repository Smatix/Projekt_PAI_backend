<?php

namespace App\Shared\Domain\ValueObject;


class Address
{
    private $street;
    private $number;
    private $postCode;
    private $city;

    /**
     * Address constructor.
     * @param $street
     * @param $number
     * @param $postCode
     * @param $city
     */
    public function __construct($street, $number, $postCode, $city)
    {
        $this->street = $street;
        $this->number = $number;
        $this->postCode = $postCode;
        $this->city = $city;
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

    public static function fromArray(array $address): self
    {
        return new self(
            $address['street'],
            $address['number'],
            $address['post_code'],
            $address['city']
        );
    }

    public function toArray(): array
    {
        return [
            'street' => $this->getStreet(),
            'number' => $this->getNumber(),
            'post_code' => $this->getPostCode(),
            'city' => $this->getCity(),
        ];
    }
}