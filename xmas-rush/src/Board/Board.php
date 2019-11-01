<?php


namespace CodingGame\XmasRush\Board;

use CodingGame\XmasRush\Point;

class Board
{
    private $state = [];

    /**
     * @param $x
     * @param $y
     * @param Tile $tile
     */
    public function set($x, $y, Tile $tile): void
    {
        $point = new Point($x,$y);
        $this->state[$point->getId()] = $tile;
    }

    /**
     * @param Point $point
     * @return Tile
     */
    public function getTile(Point $point): ?Tile
    {
        return $this->state[$point->getId()] ?? null;
    }

    public function getPointAbove(Point $point): ?Point
    {
        return $point->getY() > 0 ? new Point($point->getX(), $point->getY() - 1) : null;
    }

    public function getPointBelow(Point $point): ?Point
    {
        return $point->getY() < 6 ? new Point($point->getX(), $point->getY() + 1) : null;
    }

    public function getPointToLeft(Point $point): ?Point
    {
        return $point->getX() > 0 ? new Point($point->getX() - 1, $point->getY()) : null;
    }

    public function getPointToRight(Point $point): ?Point
    {
        return $point->getX() < 6 ? new Point($point->getX() + 1, $point->getY()) : null;
    }

    public function clear(): void
    {
        $this->state = [];
    }
}