<?php

namespace App\Shared\Infrastructure\Uuid;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface as RamseyUuid;

class RamseyUuidAdapter implements UuidInterface
{
    /**
     * @var RamseyUuid
     */
    private $id;
    private function __construct(RamseyUuid $id)
    {
        $this->id = $id;
    }
    public static function generate(): UuidInterface
    {
        return new self(Uuid::uuid4());
    }
    public static function fromString(string $id): UuidInterface
    {
        return new self(Uuid::fromString($id));
    }
    public function toString(): string
    {
        return $this->id->toString();
    }

    public function __toString()
    {
        return $this->id->toString();
    }


}