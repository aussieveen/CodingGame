<?php

namespace CodingGame\XmasRush\Board;

use CodingGame\XmasRush\Item\BoardItem;
use CodingGame\XmasRush\Item\BoardItemCollection;
use CodingGame\XmasRush\Item\Item;
use CodingGame\XmasRush\Point;

class Board
{
    private $state = [];

    /**
     * @var array
     */
    private $boardItemReference;

    /**
     * @param $x
     * @param $y
     * @param Tile $tile
     */
    public function set($x, $y, Tile $tile): void
    {
        $point = new Point($x, $y);
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

    public function setBoardItem(BoardItem $item)
    {
        $this->getTile($item->getPoint())->setBoardItem($item);
        $this->boardItemReference[] = $item->getPoint();
    }

    public function getBoardItemOnPoint(Point $point): ?Item
    {
        return $this->getTile($point)->getBoardItem();
    }

    public function getItemsOnBoard(): BoardItemCollection
    {
        $boardItemCollection = new BoardItemCollection();
        foreach ($this->boardItemReference as $reference) {
            $item = $this->getTile($reference)->getBoardItem();
            if (null !== $item) {
                $boardItemCollection->add($item);
            }
        }
        return $boardItemCollection;
    }

    public function addTileToBoard(Tile $tile, Point $point)
    {
        $x = $point->getX();
        $y = $point->getY();
        if (7 === $point->getX()) {
            for ($i = 1; $i < 7; $i++) {
                $tileToMove = $this->getTile(new Point($i, $y));
                $moveTileToPoint = new Point($i - 1, $y);
                $state[$moveTileToPoint->getId()] = $tileToMove;
            }
            $state[(new Point($x - 1, $y))->getId()] = $tile;
        }

        if (-1 === $point->getX()) {
            for ($i = 7; $i > 1; $i--) {
                $tileToMove = $this->getTile(new Point($i, $y));
                $moveTileToPoint = new Point($i + 1, $y);
                $state[$moveTileToPoint->getId()] = $tileToMove;
            }
            $state[(new Point($x + 1, $y))->getId()] = $tile;
        }

        if (7 === $point->getY()) {
            for ($i = 1; $i < 7; $i++) {
                $tileToMove = $this->getTile(new Point($x, $i));
                $moveTileToPoint = new Point($x, $i - 1);
                $state[$moveTileToPoint->getId()] = $tileToMove;
            }
            $state[(new Point($x, $y - 1))->getId()] = $tile;
        }

        if (-1 === $point->getY()) {
            for ($i = 7; $i > 1; $i--) {
                $tileToMove = $this->getTile(new Point($x, $i));
                $moveTileToPoint = new Point($x, $i + 1);
                $state[$moveTileToPoint->getId()] = $tileToMove;
            }
            $state[(new Point($x, $y + 1))->getId()] = $tile;
        }

    }

    public function clear(): void
    {
        $this->state = [];
    }
}