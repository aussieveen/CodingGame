<?php


namespace CodingGame\CodeVsZombies\Characters;


class Zombie extends Character implements Moveable, Identifiable, Attacker
{

    const MOVE_DISTANCE = 400;
    const KILL_DISTANCE = 400;

    private $id;
    private $futureX;
    private $futureY;

    public function __construct($id, $posX, $posY, $futureX, $futureY)
    {
        parent::__construct($posX, $posY);
        $this->id = $id;
        $this->futureX = $futureX;
        $this->futureY = $futureY;
    }

    public function getFutureX():int
    {
        return $this->futureX;
    }

    public function getFutureY():int
    {
        return $this->futureY;
    }

    public function setId(int $id):void
    {
        $this->id = $id;
    }

    public function getId():int
    {
        return $this->id;
    }

    public function getMoveDistance():int
    {
        return self::MOVE_DISTANCE;
    }

    public function getKillDistance():int
    {
        return self::KILL_DISTANCE;
    }
}