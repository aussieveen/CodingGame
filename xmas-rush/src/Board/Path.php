<?php


namespace CodingGame\XmasRush\Board;

use CodingGame\XmasRush\Point;

class Path
{

    private $queue = [];

    private $visitedPoints;

    private $pointsOnPath = [];
    /**
     * @var Board
     */
    private $board;

    public function __construct(Point $point, Board $board)
    {
        $this->board = $board;
        $this->queue = [$point];
        $this->visitedPoints = [];

        while (!empty($this->queue)){
            $examiningPoint = $this->queue[0];
            array_shift($this->queue);
            $this->visitedPoints[] = $examiningPoint->getId();

            $tile = $board->getTile($examiningPoint);
            if ($tile === null){
                continue;
            }

            if ($tile->hasUpPath()
                && ($p = $board->getPointAbove($examiningPoint)) instanceof Point
                && ($pTile = $board->getTile($p)) instanceof Tile
                && $pTile->hasDownPath()
            )
            {
                $this->addPointToQueue($p);
            }

            if ($tile->hasDownPath()
                && ($p = $board->getPointBelow($examiningPoint)) instanceof Point
                && ($pTile = $board->getTile($p)) instanceof Tile
                && $pTile->hasUpPath())
            {
                $this->addPointToQueue($p);
            }

            if ($tile->hasLeftPath()
                && ($p = $board->getPointToLeft($examiningPoint)) instanceof Point
                && ($pTile = $board->getTile($p)) instanceof Tile
                && $pTile->hasRightPath())
            {
                $this->addPointToQueue($p);
            }

            if ($tile->hasRightPath()
                && ($p = $board->getPointToRight($examiningPoint)) instanceof Point
                && ($pTile = $board->getTile($p)) instanceof Tile
                && $pTile->hasLeftPath())
            {
                $this->addPointToQueue($p);
            }

            $this->pointsOnPath[] = $examiningPoint;
        }
    }

    public function getPointsOnPath() : array{
        return $this->pointsOnPath;
    }

    public function isPointOnPath(Point $point) : bool{
        $pointId = $point->getId();
        foreach($this->pointsOnPath as $pathPoint){
            if ($pathPoint->getId() === $pointId){
                return true;
            }
        }
        return false;
    }

    public function getDirectionsForPointAToPointB(Point $pointA, Point $pointB) : string
    {
        $this->visitedPoints = [];
        $this->queue = [$pointA];
        $directionsTo[$pointA->getId()] = '';
        while(!empty($this->queue)){
            $currentPoint = $this->queue[0];
            array_shift($this->queue);
            $this->visitedPoints[] = $currentPoint->getId();


            $tile = $this->board->getTile($currentPoint);
            if ($tile === null){
                continue;
            }

            if ($tile->hasUpPath()
                && ($p = $this->board->getPointAbove($currentPoint)) instanceof Point
                && ($pTile = $this->board->getTile($p)) instanceof Tile
                && $pTile->hasDownPath()
            )
            {
                $this->addPointToQueue($p);
                $directionsTo[$p->getId()] = $directionsTo[$currentPoint->getID()] . 'UP,';
                if ($p->getId() === $pointB->getId()){
                    return $directionsTo[$p->getId()];
                }
            }

            if ($tile->hasDownPath()
                && ($p = $this->board->getPointBelow($currentPoint)) instanceof Point
                && ($pTile = $this->board->getTile($p)) instanceof Tile
                && $pTile->hasUpPath())
            {
                $this->addPointToQueue($p);
                $directionsTo[$p->getId()] = $directionsTo[$currentPoint->getID()] . 'DOWN,';
                if ($p->getId() === $pointB->getId()){
                    return $directionsTo[$p->getId()];
                }
            }

            if ($tile->hasLeftPath()
                && ($p = $this->board->getPointToLeft($currentPoint)) instanceof Point
                && ($pTile = $this->board->getTile($p)) instanceof Tile
                && $pTile->hasRightPath())
            {
                $this->addPointToQueue($p);
                $directionsTo[$p->getId()] = $directionsTo[$currentPoint->getID()] . 'LEFT,';
                if ($p->getId() === $pointB->getId()){
                    return $directionsTo[$p->getId()];
                }
            }

            if ($tile->hasRightPath()
                && ($p = $this->board->getPointToRight($currentPoint)) instanceof Point
                && ($pTile = $this->board->getTile($p)) instanceof Tile
                && $pTile->hasLeftPath())
            {
                $this->addPointToQueue($p);
                $directionsTo[$p->getId()] = $directionsTo[$currentPoint->getID()] . 'RIGHT,';
                if ($p->getId() === $pointB->getId()){
                    return $directionsTo[$p->getId()];
                }
            }
        }
        return '';
    }

    private function addPointToQueue(Point $p) : void
    {
        if (!in_array($p->getId(), $this->visitedPoints, true)){
            $this->queue[] = $p;
        }
    }

}