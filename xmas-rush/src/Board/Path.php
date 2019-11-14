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
            $currentPoint = $this->queue[0];
            array_shift($this->queue);
            $this->visitedPoints[] = $currentPoint->getId();

            if ($this->hasConnectingPathUp($currentPoint))
            {
                $this->addPointToQueue($this->board->getPointAbove($currentPoint));
            }

            if ($this->hasConnectingPathDown($currentPoint))
            {
                $this->addPointToQueue($this->board->getPointBelow($currentPoint));
            }

            if ($this->hasConnectingPathLeft($currentPoint))
            {
                $this->addPointToQueue($this->board->getPointToLeft($currentPoint));
            }

            if ($this->hasConnectingPathRight($currentPoint))
            {
                $this->addPointToQueue($this->board->getPointToRight($currentPoint));
            }
            $this->pointsOnPath[] = $currentPoint;
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

            if ($this->hasConnectingPathUp($currentPoint))
            {
                $p = $this->board->getPointAbove($currentPoint);
                $this->addPointToQueue($p);
                $directionsTo[$p->getId()] = $directionsTo[$currentPoint->getID()] . 'UP,';
                if ($p->getId() === $pointB->getId()){
                    return $directionsTo[$p->getId()];
                }
            }

            if ($this->hasConnectingPathDown($currentPoint))
            {
                $p = $this->board->getPointBelow($currentPoint);
                $this->addPointToQueue($p);
                $directionsTo[$p->getId()] = $directionsTo[$currentPoint->getID()] . 'DOWN,';
                if ($p->getId() === $pointB->getId()){
                    return $directionsTo[$p->getId()];
                }
            }

            if ($this->hasConnectingPathLeft($currentPoint))
            {
                $p = $this->board->getPointToLeft($currentPoint);
                $this->addPointToQueue($p);
                $directionsTo[$p->getId()] = $directionsTo[$currentPoint->getID()] . 'LEFT,';
                if ($p->getId() === $pointB->getId()){
                    return $directionsTo[$p->getId()];
                }
            }

            if ($this->hasConnectingPathRight($currentPoint))
            {
                $p = $this->board->getPointToRight($currentPoint);
                $this->addPointToQueue($p);
                $directionsTo[$p->getId()] = $directionsTo[$currentPoint->getID()] . 'RIGHT,';
                if ($p->getId() === $pointB->getId()){
                    return $directionsTo[$p->getId()];
                }
            }
        }
        return '';
    }

    private function hasConnectingPathUp(Point $point){
        $tile = $this->board->getTile($point);
        return $tile->hasUpPath()
        && ($p = $this->board->getPointAbove($point)) instanceof Point
        && ($pTile = $this->board->getTile($p)) instanceof Tile
        && $pTile->hasDownPath();
    }

    private function hasConnectingPathDown(Point $point){
        $tile = $this->board->getTile($point);
        return $tile->hasDownPath()
        && ($p = $this->board->getPointBelow($point)) instanceof Point
        && ($pTile = $this->board->getTile($p)) instanceof Tile
        && $pTile->hasUpPath();
    }

    private function hasConnectingPathLeft(Point $point){
        $tile = $this->board->getTile($point);
        return $tile->hasLeftPath()
        && ($p = $this->board->getPointToLeft($point)) instanceof Point
        && ($pTile = $this->board->getTile($p)) instanceof Tile
        && $pTile->hasRightPath();
    }

    private function hasConnectingPathRight(Point $point){
        $tile = $this->board->getTile($point);
        return $tile->hasRightPath()
        && ($p = $this->board->getPointToRight($point)) instanceof Point
        && ($pTile = $this->board->getTile($p)) instanceof Tile
        && $pTile->hasLeftPath();
    }

    private function addPointToQueue(Point $p) : void
    {
        if (!in_array($p->getId(), $this->visitedPoints, true)){
            $this->queue[] = $p;
        }
    }

}