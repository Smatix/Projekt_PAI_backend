<?php

namespace App\Staying\Application\Service;


use App\ParkingSearch\Infrastructure\Repository\ParkingReadRepository;

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

    public function getAmountOfStaying($start, $typeName, $parkingId)
    {
        $parking = $this->parkingRepository->getParkingById($parkingId);
        $amount = 0;
        foreach ($parking->getPriceList() as $item) {
            if ($item['type'] === $typeName) {
                $amount = $this->calculateAmount($start, $item);
            }
        }
        return $amount;
    }

    private function calculateAmount(\DateTime $start, $priceListItem)
    {
        $timeDifference = $start->diff(new \DateTime('now'));
        if ($priceListItem['unit'] === 'h' && $priceListItem['period'] === '1') {
            return ($timeDifference->h + 1)*intval($priceListItem['price']);
        }
    }
}