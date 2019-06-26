<?php

namespace CodingGame\CodeVsZombies\Geometry;

use CodingGame\CodeVsZombies\Characters\Character;

trait Geometry{
    function distanceBetweenCharacters(Character $char1, Character $char2): float{
        return sqrt(pow($char1->getPosX() - $char2->getPosX(), 2) + pow($char1->getPosY() - $char2->getPosY(), 2));
    }

    function getCentroidCoordinates(Character ...$characters):Coordinates{
        $xSum = 0;
        $ySum = 0;
        foreach($characters as $character){
            $xSum += $character->getPosX();
            $ySum += $character->getPosY();
        }
        return new Coordinates($xSum/count($characters),$ySum/count($characters));
    }
}