<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 18.12.2019
 * Time: 20:39
 */

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
}