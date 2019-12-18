<?php

namespace App\Shared\Infrastructure\Uuid;

interface UuidInterface
{
    public static function generate(): UuidInterface;
    public static function fromString(string $id): UuidInterface;
    public function toString(): string;
}