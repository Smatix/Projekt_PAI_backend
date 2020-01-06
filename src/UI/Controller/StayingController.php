<?php

namespace App\UI\Controller;

use App\Staying\Application\Command\Finish\FinishStayingCommand;
use App\Staying\Application\Service\StayingPriceCounter;
use App\Staying\Infrastructure\StayingReadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class StayingController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var StayingReadRepository
     */
    private $repository;

    /**
     * @var StayingPriceCounter
     */
    private $priceCounter;

    /**
     * StayingController constructor.
     * @param MessageBusInterface $messageBus
     * @param StayingReadRepository $repository
     * @param StayingPriceCounter $priceCounter
     */
    public function __construct(MessageBusInterface $messageBus, StayingReadRepository $repository, StayingPriceCounter $priceCounter)
    {
        $this->messageBus = $messageBus;
        $this->repository = $repository;
        $this->priceCounter = $priceCounter;
    }


    /**
     * @Route("/api/user/stayings", methods="GET", name="get_user_stayings")
     * @return JsonResponse
     */
    public function getUserStayings()
    {
        $data = $this->repository->getCurrentStayingByUser($this->getUser()->getId());
        foreach ($data as &$item) {
            $item['amount']= $this->priceCounter->getAmountOfStaying(
                $item['start'],
                $item['type'],
                $item['parkingId']
            );
            $item['start_timestamp'] = $item['start']->getTimestamp();
        }
        return $this->json($data);
    }

    /**
     * @Route("/api/stayings/{id}/finish", methods="PATCH", name="finish_staying")
     * @param $id
     * @return JsonResponse
     */
    public function finishStaying($id)
    {
        $command = new FinishStayingCommand($id);
        $this->messageBus->dispatch($command);
        return $this->json('Staying was finish', 200);
    }
}