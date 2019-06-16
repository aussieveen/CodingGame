<?php


namespace CodingGame\CodeVsZombies\Characters;


interface Identifiable
{
    public function setId(int $id):void;
    public function getId():int;
}