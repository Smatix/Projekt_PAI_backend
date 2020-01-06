<?php

namespace App\Payment\Domain;


interface PaymentStoreRepositoryInterface
{
    public function getById(string $id);

    public function save(Payment $reservation);
}