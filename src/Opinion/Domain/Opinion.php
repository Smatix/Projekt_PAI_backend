<?php

namespace App\Opinion\Domain;


class Opinion
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
     * @var \DateTime
     */
    private $created;

    /**
     * Opinion constructor.
     * @param string $id
     * @param int $rate
     * @param string $comment
     * @param string $author
     * @param string $parkingId
     * @throws \Exception
     */
    public function __construct(
        string $id,
        int $rate,
        string $comment,
        string $author,
        string $parkingId
    )
    {
        $this->id = $id;
        $this->rate = $rate;
        $this->comment = $comment;
        $this->author = $author;
        $this->parkingId = $parkingId;
        $this->created = new \DateTime('now');
    }


}