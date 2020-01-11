<?php

namespace App\Staying\Application\Service;

use App\Parking\Infrastructure\ParkingReadRepository;

class StayingPriceCounter
{
    /**
     * @var ParkingReadRepository
     */
    private $parkingRepository;

    /**
     * StayingPriceCounter constructor.
     * @param ParkingReadRepository $parkingRepository
     */
    public function __construct(ParkingReadRepository $parkingRepository)
    {
        $this->parkingRepository = $parkingRepository;
    }

    public function getAmountOfStaying($parkingId, $typeName, $start, $end = null)
    {
        if (!$end) {
            $end = new \DateTime('now');
        }
        $priceList = $this->parkingRepository->getPriceListFromParkingBySpaceType($parkingId, $typeName);
        $amount = 0;
        foreach ($priceList as $item) {
            $amount = $this->calculateAmount($item, $start, $end);
        }
        return $amount;
    }

    private function calculateAmount($priceListItem, \DateTime $start, \DateTime $end)
    {
        $timeDifference = $start->diff($end);
        if ($priceListItem['unit'] === 'h' && $priceListItem['period'] === 1) {
            return ($timeDifference->h + 1)*intval($priceListItem['price']);
        }
    }
}