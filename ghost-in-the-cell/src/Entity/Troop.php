<?php


namespace CodeInGame\GhostInTheCell\Entity;


class Troop
{
    /**
     * @var int
     */
    private $owner;
    /**
     * @var int
     */
    private $sentFrom;
    /**
     * @var int
     */
    private $destination;
    /**
     * @var int
     */
    private $cyborgs;
    /**
     * @var int
     */
    private $arrivalTime;

    /**
     * Troop constructor.
     * @param int $owner
     * @param int $sentFrom
     * @param int $destination
     * @param int $cyborgs
     * @param int $arrivalTime
     */
    public function __construct(int $owner, int $sentFrom, int $destination, int $cyborgs, int $arrivalTime)
    {
        $this->owner = $owner;
        $this->sentFrom = $sentFrom;
        $this->destination = $destination;
        $this->cyborgs = $cyborgs;
        $this->arrivalTime = $arrivalTime;
    }
}