<?php

namespace CodingGame\XmasRush\Player;

use CodingGame\XmasRush\Board\Tile;
use CodingGame\XmasRush\Interfaces\Positionable;
use CodingGame\XmasRush\Point;

class Player implements Positionable
{

    private $numberOfQuests;

    private $tile;
    /**
     * @var Point
     */
    private $point;

    public function updateState(int $numberOfQuests, int $x, int $y, Tile $tile): void
    {
        $this->numberOfQuests = $numberOfQuests;
        $this->point = new Point($x, $y);
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
     * @return Tile
     */
    public function getTile() : Tile
    {
        return $this->tile;
    }


    public function getPoint(): Point
    {
        return $this->point;
    }
}