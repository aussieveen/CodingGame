<?php

namespace CodingGame\CodeVsZombies\Geometry;

use CodingGame\CodeVsZombies\Characters\Character;

trait Geometry
{
    public function distanceBetweenCharacters(Character $char1, Character $char2): float
    {
        return sqrt((($char1->getPosX() - $char2->getPosX()) ** 2) + (($char1->getPosY() - $char2->getPosY()) ** 2));
    }

    public function getCentroidCoordinates(Character ...$characters): array
    {
        $xSum = 0;
        $ySum = 0;
        foreach ($characters as $character) {
            $xSum += $character->getPosX();
            $ySum += $character->getPosY();
        }
        return ['x' => $xSum / count($characters), 'y' => $ySum / count($characters)];
    }
}