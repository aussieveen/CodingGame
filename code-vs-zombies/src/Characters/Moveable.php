<?php

namespace CodingGame\CodeVsZombies\Characters;

interface Moveable{

    public function getFutureX():int;
    public function getFutureY():int;
    public function getMoveDistance():int;
}