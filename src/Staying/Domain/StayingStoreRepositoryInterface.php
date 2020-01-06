<?php

namespace App\Staying\Domain;


interface StayingStoreRepositoryInterface
{
    public function getById(string $id);

    public function save(Staying $staying);
}