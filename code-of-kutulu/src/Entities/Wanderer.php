<?php


namespace CodingGame\CodeOfKutulu\Entities;


use CodingGame\CodeOfKutulu\Coordinates;

class Wanderer implements Identifiable,Positionable
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $time;
    /**
     * @var int
     */
    private $state;
    /**
     * @var int
     */
    private $explorerTarget;
    /**
     * @var Coordinates
     */
    private $coordinates;

    public function __construct(int $id, int $xPos, int $yPos, int $time, int $state, int $explorerTarget)
    {
        $this->id = $id;
        $this->coordinates = new Coordinates($xPos,$yPos);
        $this->time = $time;
        $this->state = $state;
        $this->explorerTarget = $explorerTarget;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getX(): int
    {
        return $this->coordinates->getX();
    }

    public function getY(): int
    {
        return $this->coordinates->getY();
    }

    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }

    public function getExplorerTarget(): int
    {
        return $this->explorerTarget;
    }
}

