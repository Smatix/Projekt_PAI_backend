<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 04.01.2020
 * Time: 20:15
 */

namespace App\Staying\Application\Command\Finish;


class FinishStayingCommand
{
    /**
     * @var string
     */
    private $id;

    /**
     * FinishStayingCommand constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}