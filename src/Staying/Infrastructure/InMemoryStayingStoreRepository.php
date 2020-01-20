<?php

namespace App\Staying\Infrastructure;

use App\Staying\Domain\Staying;
use App\Staying\Domain\StayingStoreRepositoryInterface;

class InMemoryStayingStoreRepository implements StayingStoreRepositoryInterface
{
    /**
     * @var array
     */
    private $stayings = [];

    public function getById(string $id)
    {
        /** @var Staying $reservation */
        foreach ($this->stayings as $staying) {
            if ($staying->getId() === $id) {
                return $staying;
            }
        }
        return null;
    }

    public function save(Staying $staying)
    {
        $this->stayings[] = $staying;
    }

    public function remove(Staying $staying)
    {
        /** @var Staying $item */
        foreach ($this->stayings as &$item) {
            if ($item->getId() === $staying->getId()) {
                unset($item);
            }
        }
    }

}