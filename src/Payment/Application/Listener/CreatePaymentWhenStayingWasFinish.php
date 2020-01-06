<?php

namespace App\Payment\Application\Listener;

use App\Payment\Domain\Factory\PaymentFactory;
use App\Payment\Domain\Payment;
use App\Payment\Domain\PaymentStoreRepositoryInterface;
use App\Shared\Infrastructure\Uuid\RamseyUuidAdapter;
use App\Staying\Domain\Event\StayingWasFinish;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreatePaymentWhenStayingWasFinish implements MessageHandlerInterface
{
    /**
     * @var PaymentStoreRepositoryInterface
     */
    private $repository;

    /**
     * CreatePaymentWhenStayingWasFinish constructor.
     * @param PaymentStoreRepositoryInterface $repository
     */
    public function __construct(PaymentStoreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(StayingWasFinish $event)
    {
        $payment = PaymentFactory::create(
            RamseyUuidAdapter::generate(),
            $event->getStayingId(),
            $event->getUserId(),
            $event->getAmount()
        );
        $payment->markAsPaid();
        $this->repository->save($payment);
    }
}