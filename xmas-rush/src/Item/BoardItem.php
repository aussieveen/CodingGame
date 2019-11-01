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

    /**
     * @return bool
     */
    public function onPlayerTile(): bool
    {
        return $this->onUserTile(-1);
    }

    /**
     * @return bool
     */
    public function onOpponentTile(): bool
    {
        return $this->onUserTile(-2);
    }

    /**
     * @param $expectedValue
     * @return bool
     */
    private function onUserTile($expectedValue): bool
    {
        return $this->point->getX() === $expectedValue && $this->point->getY() === $expectedValue;
    }
}