<?php

namespace CodingGame\CodeVsZombies\Characters;

use CodingGame\CodeVsZombies\Geometry\Coordinates;

abstract class Character{

    /**
     * @var Coordinates
     */
    private $coordinates;

    /**
     * Character constructor.
     * @param Coordinates $coordinates
     * @internal param int $posX
     * @internal param int $posY
     */
    public function __construct(Coordinates $coordinates)
    {
        $this->coordinates = $coordinates;
    }

    /**
     * @return Coordinates
     */
    public function getCoordinates():Coordinates
    {
        return $this->coordinates;
    }

    /**
     * @return mixed
     */
    public function getPosX():int
    {
        return $this->coordinates->getX();
    }

    /**
     * @return mixed
     */
    public function getPosY():int
    {
        return $this->coordinates->getY();
    }

}