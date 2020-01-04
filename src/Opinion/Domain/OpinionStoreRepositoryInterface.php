<?php

namespace App\Opinion\Domain;


interface OpinionStoreRepositoryInterface
{
    public function getById(string $id);

    public function save(Opinion $opinion);
}