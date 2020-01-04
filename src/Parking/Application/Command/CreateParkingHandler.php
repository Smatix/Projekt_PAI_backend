<?php

namespace App\Parking\Application\Command;

use App\Parking\Domain\Model\OpeningHours;
use App\Parking\Domain\Model\PriceList;
use App\Parking\Domain\Parking;
use App\Parking\Domain\Model\ParkingSpace;
use App\Parking\Domain\ParkingStoreRepositoryInterface;
use App\Parking\Infrastructure\Coordinate\CoordinateInterface;
use App\Shared\Infrastructure\Repository\ParkingSpaceTypeRepository;
use App\Shared\Infrastructure\Uuid\RamseyUuidAdapter;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateParkingHandler implements MessageHandlerInterface
{
    private $repository;
    private $spaceTypeRepository;
    private $coordinateConverter;

    /**
     * RegisterUserHandler constructor.
     * @param ParkingStoreRepositoryInterface $repository
     * @param ParkingSpaceTypeRepository $spaceTypeRepository
     * @param CoordinateInterface $coordinateConverter
     */
    public function __construct(ParkingStoreRepositoryInterface $repository,
                                ParkingSpaceTypeRepository $spaceTypeRepository,
                                CoordinateInterface $coordinateConverter)
    {
        $this->repository = $repository;
        $this->spaceTypeRepository = $spaceTypeRepository;
        $this->coordinateConverter = $coordinateConverter;
    }

    public function __invoke(CreateParkingCommand $command)
    {
        $parking = new Parking(
            $command->getId(),
            $command->getName(),
            $command->getAddress(),
            $command->getOwner()
        );

        $parkingSpaceTypes = $this->spaceTypeRepository->getAll();
        $coordinate = $this->coordinateConverter->convertAddressToCoordinate($command->getAddress());
        $parking->setCoordinate($coordinate);

        foreach ($command->getParkingSpace() as $item) {
            $parkingSpace = new ParkingSpace($parkingSpaceTypes[$item['type']], $item['count']);
            $parking->addParkingSpace($parkingSpace);
        }

        foreach ($command->getPriceList() as $item) {
            $priceList = new PriceList(
                $parkingSpaceTypes[$item['type']],
                $item['period'],
                $item['unit'],
                $item['price']
            );
            $parking->addPriceList($priceList);
        }

        foreach ($command->getOpeningHours() as $item) {
            $openingHours = new OpeningHours($item['day'], $item['open'], $item['close']);
            $parking->addOpeningHours($openingHours);
        }

        $this->repository->save($parking);
    }
}