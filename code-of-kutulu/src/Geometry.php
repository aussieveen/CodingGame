<?php


namespace CodeInGame\CodeOfKutulu;

use CodingGame\CodeOfKutulu\Coordinates;

trait Geometry
{
    public function manhattanDistance(Coordinates $coordinateOne, Coordinates $coordinateTwo):int {
        return abs($coordinateOne->getX() - $coordinateTwo->getX()) + abs($coordinateOne->getY() - $coordinateTwo->getY());
    }
}