<?php

namespace CodingGame\CodeVsZombies\Characters;

class Human extends Character implements Identifiable {

    private $id;

    /**
     * Human constructor.
     * @param int $id
     * @param int $posX
     * @param int $posY
     */
    public function __construct(int $id, int $posX, int $posY)
    {
        parent::__construct($posX, $posY);
        $this->id = $id;
    }


    public function setId(int $id):void
    {
        $this->id = $id;
    }

    public function getId():int
    {
        return $this->id;
    }
}