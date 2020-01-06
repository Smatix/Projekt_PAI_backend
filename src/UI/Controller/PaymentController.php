<?php

namespace App\UI\Controller;

use App\Payment\Infrastructure\PaymentReadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @var PaymentReadRepository
     */
    private $repository;

    /**
     * PaymentController constructor.
     * @param PaymentReadRepository $repository
     */
    public function __construct(PaymentReadRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/api/user/payments", methods="GET", name="payments")
     * @return JsonResponse
     */
    public function getUserReservations()
    {
        $data = $this->repository->getPaymentByUser($this->getUser()->getId());
        return $this->json($data);
    }
}