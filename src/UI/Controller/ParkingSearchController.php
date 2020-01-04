<?php

namespace App\UI\Controller;

use App\Parking\Application\Command\CreateParkingCommand;
use App\ParkingSearch\Infrastructure\Repository\ParkingReadRepository;
use App\Shared\Domain\ValueObject\Address;
use App\Shared\Infrastructure\Uuid\RamseyUuidAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ParkingSearchController extends AbstractController
{
    private $repository;

    /**
     * DefaultController constructor.
     * @param ParkingReadRepository $repository
     */
    public function __construct(ParkingReadRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/api/parkings/coordinate", methods="POST", name="get_parking")
     * @param Request $request
     * @return Response
     */
    public function getParkingsByCoordinate(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $result = $this->repository->getParkingsByCoordinate($data['north'], $data['east'], $data['south'], $data['west']);
        return $this->json($result);
    }

    /**
     * @Route("/api/parkings/search", methods="GET", name="get_parking_by_city")
     * @param Request $request
     * @return Response
     */
    public function getParkingsByCity(Request $request)
    {
        $city = $request->get('city');
        $result = $this->repository->getParkingsByCity($city);
        return $this->json($result);
    }

    /**
     * @Route("/api/parkings/{id}", methods="GET", name="get_parking_by_id")
     * @param string $id
     * @param Request $request
     * @return Response
     */
    public function getParkingById($id, Request $request)
    {
        $result = $this->repository->getParkingById($id);
        if (!$result) {
            $msg = ['code' => 404, 'message' =>'Parking not found'];
            return $this->json($msg, 404);
        }
        return $this->json($result);
    }

    /**
     * @Route("/api/parkings", methods="POST", name="create_parking")
     * @param Request $request
     * @return Response
     */
    public function createParking(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $id = RamseyUuidAdapter::generate();
        $command = new CreateParkingCommand(
            $id,
            $data['name'],
            Address::fromArray($data['address']),
            $this->getUser()->getId()
        );
        $command->setOpeningHours($data['open_list']);
        $command->setParkingSpace($data['parking_space']);
        $command->setPriceList($data['price_list']);
        $this->messageBus->dispatch($command);
        return $this->json($id, 201);

    }
}