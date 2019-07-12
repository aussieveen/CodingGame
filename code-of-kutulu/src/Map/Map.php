<?php


namespace CodeInGame\CodeOfKutulu\Map;


use CodingGame\CodeOfKutulu\Coordinates;

class Map
{
    const WALL = "#";
    const WANDERER = "w";
    const EMPTY = ".";

    private $width;
    private $height;
    private $rowCounter = 0;
    private $grid = [];

    /**
     * Map constructor.
     */
    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function addMapRow(string $mapSymbols)
    {
        $this->grid[$this->rowCounter] = str_split($mapSymbols);
        $this->rowCounter++;
    }

    public function isWall(Coordinates $coordinates){
        return $this->grid[$coordinates->getY()][$coordinates->getX()] === self::WALL;
    }

}