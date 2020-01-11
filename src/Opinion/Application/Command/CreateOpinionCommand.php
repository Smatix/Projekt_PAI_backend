<?php

namespace App\Opinion\Application\Command;


use App\Shared\Infrastructure\Uuid\RamseyUuidAdapter;

class CreateOpinionCommand
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var integer
     */
    private $rate;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $parkingId;

    /**
     * CreateOpinionCommand constructor.
     * @param string $id
     */
    public function __construct()
    {
        $this->id = RamseyUuidAdapter::generate();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getRate(): ?int
    {
        return $this->rate;
    }

    /**
     * @param int $rate
     */
    public function setRate(int $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getParkingId(): ?string
    {
        return $this->parkingId;
    }

    /**
     * @param string $parkingId
     */
    public function setParkingId(string $parkingId): void
    {
        $this->parkingId = $parkingId;
    }

}