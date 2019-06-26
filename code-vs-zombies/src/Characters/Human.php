<?php

namespace CodingGame\CodeVsZombies\Characters;

use CodingGame\CodeVsZombies\Geometry\Coordinates;

class Human extends Character implements Identifiable {

    private $id;

    /**
     * Human constructor.
     * @param int $id
     * @param Coordinates $coordinates
     * @internal param int $posX
     * @internal param int $posY
     */
    public function __construct(int $id, Coordinates $coordinates)
    {
        parent::__construct($coordinates);
        $this->id = $id;
}

    public function getId():int
    {
        return $this->id;
    }
}