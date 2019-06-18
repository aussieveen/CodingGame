<?php

namespace CodingGame\CodeVsZombies;

use CodingGame\CodeVsZombies\Characters\Character;

trait Geometry{
    function distanceBetweenPoints(Character $char1, Character $char2): float{
        return sqrt(pow($char1->getPosX() - $char2->getPosX(), 2) + pow($char1->getPosY() - $char2->getPosY(), 2));
    }
}