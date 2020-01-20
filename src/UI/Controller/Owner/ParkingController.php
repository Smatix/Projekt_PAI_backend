<?php

namespace App\UI\Controller\Owner;

use App\Parking\Application\Command\CreateParkingCommand;
use App\Shared\Domain\ValueObject\Address;
use App\Shared\Infrastructure\Uuid\RamseyUuidAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;


class ParkingController extends AbstractController
{
    private $messageBus;

    /**
     * DefaultController constructor.
     * @param $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @Route("/api/owner/parkings", methods="POST", name="create_parking")
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