<?php


namespace CodingGame\CodeOfKutulu\Entities;


use CodingGame\CodeOfKutulu\Coordinates;

interface Positionable
{
    public function getCoordinates():Coordinates;
    public function getX():int;
    public function getY():int;
}