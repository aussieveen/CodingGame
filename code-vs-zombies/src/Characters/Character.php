<?php

namespace CodingGame\CodeVsZombies\Characters;

abstract class Character
{
    private $posX;
    private $posY;

    /**
     * Character constructor.
     * @param int $posX
     * @param int $posY
     */
    public function __construct(int $posX, int $posY)
    {
        $this->posX = $posX;
        $this->posY = $posY;
    }

    /**
     * @return mixed
     */
    public function getPosY(): int
    {
        return $this->posY;
    }

    /**
     * @return mixed
     */
    public function getPosX(): int
    {
        return $this->posX;
    }
}