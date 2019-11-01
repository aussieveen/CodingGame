<?php


namespace CodingGame\XmasRush\Board;


use CodingGame\XmasRush\Point;

class PathCollection
{
    /**
     * @var Board
     */
    private $board;

    private $paths;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    public function getPathForPoint(Point $point): Path{
        $pointId = $point->getId();

        if(!isset($this->paths[$pointId])){
            $this->setPathForPoint($point);
        }

        return $this->paths[$pointId];

    }

    private function setPathForPoint(Point $point) : void
    {
        $path = new Path($point, $this->board);

        $this->paths[$point->getId()] = $path;
        foreach($path->getPointsOnPath() as $pathPoint){
            $this->paths[$pathPoint->getId()] = $path;
        }
    }
}