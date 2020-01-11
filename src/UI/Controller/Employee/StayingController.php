<?php

namespace App\UI\Controller\Employee;

use App\Parking\Infrastructure\ParkingReadRepository;
use App\Staying\Application\Command\Active\ActiveStayingCommand;
use App\Staying\Application\Command\Finish\FinishStayingCommand;
use App\Staying\Application\Command\Resume\ResumeStayingCommand;
use App\Staying\Application\Service\StayingPriceCounter;
use App\Staying\Infrastructure\StayingReadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class StayingController extends AbstractController
{
    /**
     * @var ParkingReadRepository
     */
    private $employeeRepository;

    /**
     * @var StayingReadRepository
     */
    private $repository;

    /**
     * @var StayingPriceCounter
     */
    private $priceCounter;

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * StayingController constructor.
     * @param ParkingReadRepository $employeeRepository
     * @param StayingReadRepository $repository
     * @param StayingPriceCounter $priceCounter
     * @param MessageBusInterface $messageBus
     */
    public function __construct(ParkingReadRepository $employeeRepository, StayingReadRepository $repository, StayingPriceCounter $priceCounter, MessageBusInterface $messageBus)
    {
        $this->employeeRepository = $employeeRepository;
        $this->repository = $repository;
        $this->priceCounter = $priceCounter;
        $this->messageBus = $messageBus;
    }

    /**
     * @Route("/api/employee/stayings", methods="GET", name="get_employee_stayings_to_accept")
     * @return JsonResponse
     */
    public function getStayingToAccept()
    {
        $parkingId = $this->employeeRepository->getParkingIdByEmployee($this->getUser()->getId());
        $data = $this->repository->getStayingToAccept($parkingId);
        return $this->json($data);
    }

    /**
     * @Route("/api/employee/active/stayings", methods="GET", name="get_employee_stayings")
     * @return JsonResponse
     */
    public function getCurrentStaying()
    {
        $parkingId = $this->employeeRepository->getParkingIdByEmployee($this->getUser()->getId());
        $data = $this->repository->getCurrentStayingByParking($parkingId);
        foreach ($data as &$item) {
            $item['amount']= $this->priceCounter->getAmountOfStaying(
                $parkingId,
                $item['type'],
                $item['start']
            );
            $item['start_timestamp'] = $item['start']->getTimestamp();
        }
        return $this->json($data);
    }

    /**
     * @Route("/api/employee/finish/stayings", methods="GET", name="get_employee_stayings_to_finish")
     * @return JsonResponse
     */
    public function getStayingToFinish()
    {
        $parkingId = $this->employeeRepository->getParkingIdByEmployee($this->getUser()->getId());
        $data = $this->repository->getStayingToFinish($parkingId);
        foreach ($data as &$item) {
            $item['amount']= $this->priceCounter->getAmountOfStaying(
                $parkingId,
                $item['type'],
                $item['start'],
                $item['end']
            );
            $item['start_timestamp'] = $item['start']->getTimestamp();
        }
        return $this->json($data);
    }

    /**
     * @Route("/api/employee/stayings/{id}/accept", methods="PATCH", name="accept_staying")
     * @param $id
     * @return JsonResponse
     */
    public function acceptStaying($id)
    {
        $command = new ActiveStayingCommand($id);
        $this->messageBus->dispatch($command);
        return $this->json('Staying was accept', 200);
    }

    /**
     * @Route("/api/employee/stayings/{id}/finish", methods="PATCH", name="finish_staying")
     * @param $id
     * @return JsonResponse
     */
    public function finishStaying($id)
    {
        $command = new FinishStayingCommand($id);
        $this->messageBus->dispatch($command);
        return $this->json('Staying was accept', 200);
    }

    /**
     * @Route("/api/employee/stayings/{id}/resume", methods="PATCH", name="resume_staying")
     * @param $id
     * @return JsonResponse
     */
    public function resumeStaying($id)
    {
        $command = new ResumeStayingCommand($id);
        $this->messageBus->dispatch($command);
        return $this->json('Staying was resume', 200);
    }
}