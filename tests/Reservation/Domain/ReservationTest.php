<?php

namespace App\Tests\Reservation\Domain;

use App\Reservation\Domain\Reservation;
use App\Reservation\Domain\Factory\ReservationFactory;
use App\Shared\Domain\Model\ParkingSpaceType;
use PHPUnit\Framework\TestCase;

class ReservationTest extends TestCase
{
    public function testMarkAsActive()
    {
        $date = new \DateTime('tomorrow');
        $reservation = ReservationFactory::create(
            '594f483a-20f0-11ea-978f-2e728ce88125',
            $date->format('Y-m-d'),
            new ParkingSpaceType('car'),
            '594f483a-20f0-11ea-978f-2e728ce88125',
            '594f483a-20f0-11ea-978f-2e728ce88125');
        $reservation->markAsActive();
        $this->assertEquals(Reservation::STATUS_ACTIVE, $reservation->getStatus());
    }

    public function testMarkAsFailed()
    {
        $date = new \DateTime('tomorrow');
        $reservation = ReservationFactory::create(
            '594f483a-20f0-11ea-978f-2e728ce88125',
            $date->format('Y-m-d'),
            new ParkingSpaceType('car'),
            '594f483a-20f0-11ea-978f-2e728ce88125',
            '594f483a-20f0-11ea-978f-2e728ce88125');
        $reservation->markAsFailed();
        $this->assertEquals(Reservation::STATUS_FAILED, $reservation->getStatus());
    }

    public function testCancelWhenActive()
    {
        $date = new \DateTime('tomorrow');
        $reservation = ReservationFactory::create(
            '594f483a-20f0-11ea-978f-2e728ce88125',
            $date->format('Y-m-d'),
            new ParkingSpaceType('car'),
            '594f483a-20f0-11ea-978f-2e728ce88125',
            '594f483a-20f0-11ea-978f-2e728ce88125');
        $reservation->markAsActive();
        $reservation->cancel();
        $this->assertEquals(Reservation::STATUS_CANCELED, $reservation->getStatus());
    }

    public function testCancelWhenPending()
    {
        $date = new \DateTime('tomorrow');
        $reservation = ReservationFactory::create(
            '594f483a-20f0-11ea-978f-2e728ce88125',
            $date->format('Y-m-d'),
            new ParkingSpaceType('car'),
            '594f483a-20f0-11ea-978f-2e728ce88125',
            '594f483a-20f0-11ea-978f-2e728ce88125');
        $reservation->cancel();
        $this->assertEquals(Reservation::STATUS_CANCELED, $reservation->getStatus());
    }

    public function testMarkAsExpired()
    {
        $date = new \DateTime('tomorrow');
        $reservation = ReservationFactory::create(
            '594f483a-20f0-11ea-978f-2e728ce88125',
            $date->format('Y-m-d'),
            new ParkingSpaceType('car'),
            '594f483a-20f0-11ea-978f-2e728ce88125',
            '594f483a-20f0-11ea-978f-2e728ce88125');
        $reservation->markAsActive();
        $reservation->markAsExpired();
        $this->assertEquals(Reservation::STATUS_EXPIRED, $reservation->getStatus());
    }

    public function testFinish()
    {
        $date = new \DateTime('now');
        $reservation = ReservationFactory::create(
            '594f483a-20f0-11ea-978f-2e728ce88125',
            $date->format('Y-m-d'),
            new ParkingSpaceType('car'),
            '594f483a-20f0-11ea-978f-2e728ce88125',
            '594f483a-20f0-11ea-978f-2e728ce88125');
        $reservation->markAsActive();
        $reservation->finish();
        $this->assertEquals(Reservation::STATUS_FINISHED, $reservation->getStatus());
    }

    public function testFinishWithBadDate()
    {
        $date = new \DateTime('tomorrow');
        $reservation = ReservationFactory::create(
            '594f483a-20f0-11ea-978f-2e728ce88125',
            $date->format('Y-m-d'),
            new ParkingSpaceType('car'),
            '594f483a-20f0-11ea-978f-2e728ce88125',
            '594f483a-20f0-11ea-978f-2e728ce88125');
        $reservation->markAsActive();
        $reservation->finish();
        $this->assertEquals(Reservation::STATUS_ACTIVE, $reservation->getStatus());
    }

    public function testIsExpired()
    {
        $date = new \DateTime('yesterday');
        $reservation = ReservationFactory::create(
            '594f483a-20f0-11ea-978f-2e728ce88125',
            $date->format('Y-m-d'),
            new ParkingSpaceType('car'),
            '594f483a-20f0-11ea-978f-2e728ce88125',
            '594f483a-20f0-11ea-978f-2e728ce88125');
        $reservation->markAsActive();
        $this->assertTrue($reservation->isExpired());
    }

    public function testIsNotExpired()
    {
        $date = new \DateTime('tomorrow');
        $reservation = ReservationFactory::create(
            '594f483a-20f0-11ea-978f-2e728ce88125',
            $date->format('Y-m-d'),
            new ParkingSpaceType('car'),
            '594f483a-20f0-11ea-978f-2e728ce88125',
            '594f483a-20f0-11ea-978f-2e728ce88125');
        $reservation->markAsActive();
        $this->assertFalse($reservation->isExpired());
    }

    public function testCanBeShared()
    {
        $date = new \DateTime('now');
        $reservation = ReservationFactory::create(
            '594f483a-20f0-11ea-978f-2e728ce88125',
            $date->format('Y-m-d'),
            new ParkingSpaceType('car'),
            '594f483a-20f0-11ea-978f-2e728ce88125',
            '594f483a-20f0-11ea-978f-2e728ce88125');
        $reservation->markAsActive();
        $this->assertTrue($reservation->canBeShared());
    }

    public function testCanNotBeShared()
    {
        $date = new \DateTime('now');
        $reservation = ReservationFactory::create(
            '594f483a-20f0-11ea-978f-2e728ce88125',
            $date->format('Y-m-d'),
            new ParkingSpaceType('car'),
            '594f483a-20f0-11ea-978f-2e728ce88125',
            '594f483a-20f0-11ea-978f-2e728ce88125');
        $reservation->markAsActive();
        $reservation->finish();
        $this->assertFalse($reservation->canBeShared());
    }

}