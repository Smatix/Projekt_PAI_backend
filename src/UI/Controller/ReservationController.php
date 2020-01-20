<?php

namespace App\UI\Controller;

use App\Reservation\Application\Command\Accept\AcceptReservationCommand;
use App\Reservation\Application\Command\Cancel\CancelReservationCommand;
use App\Reservation\Application\Command\Create\CreateReservationCommand;
use App\Reservation\Application\Command\Delete\DeleteReservationCommand;
use App\Reservation\Application\Command\Finish\FinishReservationCommand;
use App\Reservation\Application\Service\ReservationCheckService;
use App\Reservation\Infrastructure\ReservationReadRepository;
use App\UI\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ReservationController extends AbstractController
{

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var ReservationCheckService
     */
    private $reservationCheck;

    /**
     * @var ReservationReadRepository
     */
    private $repository;

    /**
     * ReservationController constructor.
     * @param MessageBusInterface $messageBus
     * @param ReservationCheckService $reservationCheck
     * @param ReservationReadRepository $repository
     */
    public function __construct(MessageBusInterface $messageBus, ReservationCheckService $reservationCheck, ReservationReadRepository $repository)
    {
        $this->messageBus = $messageBus;
        $this->reservationCheck = $reservationCheck;
        $this->repository = $repository;
    }


    /**
     * @Route("/api/user/reservations", methods="GET", name="get_user_reservations")
     * @return JsonResponse
     */
    public function getUserReservations()
    {
        $data = $this->repository->getCurrentReservationByUser($this->getUser()->getId());
        return $this->json($data);
    }

    /**
     * @Route("/api/user/reservations/finished", methods="GET", name="get_user_finished_reservations")
     * @return JsonResponse
     */
    public function getUserFinishedReservations()
    {
        $data = $this->repository->getFinishedReservationByUser($this->getUser()->getId());
        return $this->json($data);
    }


    /**
     * @Route("/api/reservations", methods="POST", name="create_reservation")
     * @param Request $request
     * @return JsonResponse
     */
    public function createReservation(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $command = new CreateReservationCommand();
        $form = $this->createForm(ReservationType::class, $command);
        $form->submit($data);
        if (!$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);
            return $this->json($errors, 400);
        }
        $reservationIsPossible = $this->reservationCheck->checkIfReservationIsPossible($command->getParkingId(),
            $command->getReservationDate(), $command->getType());
        if (!$reservationIsPossible) {
            return $this->json(['reservationDate' => 'Reservation is impossible in this term'], 400);
        }
        $command->setUserId($this->getUser()->getId());
        $this->messageBus->dispatch($command);
        return $this->json($command->getId(), 201);
    }

    /**
     * @Route("/api/reservations/{id}/cancel", methods="PATCH", name="cancel_reservation")
     * @param $id
     * @return JsonResponse
     */
    public function cancelReservation($id)
    {
        $command = new CancelReservationCommand($id);
        $this->messageBus->dispatch($command);
        return $this->json('Reservation was cancel', 200);
    }

    /**
     * @Route("/api/reservations/{id}/accept", methods="PATCH", name="accept_reservation")
     * @param $id
     * @return JsonResponse
     */
    public function acceptReservation($id)
    {
        $command = new AcceptReservationCommand($id);
        $this->messageBus->dispatch($command);
        return $this->json('Reservation was accept', 200);
    }

    /**
     * @Route("/api/user/reservations/{id}", methods="DELETE", name="delete_reservation")
     * @param $id
     * @return JsonResponse
     */
    public function deleteReservation($id)
    {
        $command = new DeleteReservationCommand($id);
        $this->messageBus->dispatch($command);
        return $this->json('', 204);
    }

    /**
     * @Route("/api/reservations/{id}/finish", methods="PATCH", name="finish_reservation")
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function finishReservation($id)
    {
        $today = new \DateTime('now');
        $reservationDate = $this->repository->getDateOfReservation($id);
        if (!($today->format('Y-m-j') === $reservationDate->format('Y-m-j'))) {
            return $this->json('Can not finish reservation', 400);
        }

        $command = new FinishReservationCommand($id);
        $this->messageBus->dispatch($command);
        return $this->json('Reservation was finish', 200);
    }

    protected function getErrorsFromForm(FormInterface $form)
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }
}