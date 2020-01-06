<?php

namespace App\Payment\Domain\Factory;


use App\Payment\Domain\Payment;

class PaymentFactory
{
    public static function create(string $id, string $stayingId, string $userId, string $amount)
    {
        return new Payment(
            $id,
            $stayingId,
            $userId,
            $amount,
            Payment::STATUS_PENDING,
            new \DateTime('now')
        );
    }
}