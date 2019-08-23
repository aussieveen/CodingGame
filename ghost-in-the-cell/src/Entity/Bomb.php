<?php


namespace CodeInGame\GhostInTheCell\Entity;


class Bomb
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
    private $detonationIn;
    private $arg5;

    /**
     * Bomb constructor.
     * @param int $owner
     * @param int $sentFrom
     * @param int $destination
     * @param int $detonationIn
     * @param $arg5
     */
    public function __construct(int $owner, int $sentFrom, int $destination, int $detonationIn, $arg5)
    {
        $this->owner = $owner;
        $this->sentFrom = $sentFrom;
        $this->destination = $destination;
        $this->detonationIn = $detonationIn;
        $this->arg5 = $arg5;
    }
}