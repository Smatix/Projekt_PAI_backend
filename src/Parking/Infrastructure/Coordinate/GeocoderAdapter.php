<?php

namespace App\Parking\Infrastructure\Coordinate;

use App\Parking\Domain\ValueObject\Coordinate;
use App\Shared\Domain\ValueObject\Address;
use OpenCage\Geocoder\Geocoder;

class GeocoderAdapter implements CoordinateInterface
{
    /**
     * @var Geocoder
     */
    private $geocoder;

    public function __construct()
    {
        $this->geocoder = new Geocoder($_ENV['GEO_API_KEY']);;
    }

    public function convertAddressToCoordinate(Address $address): Coordinate
    {
        $addressString = $address->getStreet().' '.$address->getNumber().', '.$address->getCity();
        $result = $this->geocoder->geocode($addressString);
        $cords = $result['results'][0]['geometry'];
        return new Coordinate($cords['lat'], $cords['lng']);
    }

}