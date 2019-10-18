<?php

namespace CodingGame\XmasRush\Player;

use CodingGame\XmasRush\Board\Tile;
use CodingGame\XmasRush\Interfaces\Positionable;

class Player implements Positionable
{

    private $numberOfQuests;

    private $x;

    private $y;

    private $tile;

    public function updateState(int $numberOfQuests, int $x, int $y, Tile $tile): void
    {
        $this->numberOfQuests = $numberOfQuests;
        $this->x = $x;
        $this->y = $y;
        $this->tile = $tile;
    }

    /**
     * @return int
     */
    public function getNumberOfQuests() : int
    {
        return $this->numberOfQuests;
    }

    /**
     * @return int
     */
    public function getX() : int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY() : int
    {
        return $this->y;
    }

    /**
     * @return Tile
     */
    public function getTile() : Tile
    {
        return $this->tile;
    }


}