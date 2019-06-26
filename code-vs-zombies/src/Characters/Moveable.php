<?php

namespace CodingGame\CodeVsZombies\Characters;

use CodingGame\CodeVsZombies\Geometry\Coordinates;

interface Moveable{

    public function getFutureCoordinates(): Coordinates;
    public function getMoveDistance():int;
}