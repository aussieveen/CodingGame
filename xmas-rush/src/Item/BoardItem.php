<?php


namespace CodingGame\XmasRush\Item;

use CodingGame\XmasRush\Interfaces\Positionable;
use CodingGame\XmasRush\Point;

class BoardItem extends Item implements Positionable
{

    private $point;

    /**
     * BoardItem constructor.
     * @param string $name
     * @param int $x
     * @param int $y
     * @param int $playerId
     */
    public function __construct(string $name, int $x, int $y, int $playerId)
    {
        $this->point = new Point($x, $y);

        parent::__construct($name, $playerId);
    }

    public function getPoint(): Point
    {
        return $this->point;
    }

    public function inPossession():bool
    {
        return $this->point->getX() < 0 && $this->point->getY() < 0;
    }
}