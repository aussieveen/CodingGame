<?php


namespace CodingGame\CodeVsZombies\Characters;

use CodingGame\CodeVsZombies\Geometry\Coordinates;
use CodingGame\CodeVsZombies\Geometry\Geometry;


class Zombie extends Character implements Moveable, Identifiable, Attacker
{
    use Geometry;

    const MOVE_DISTANCE = 400;
    const KILL_DISTANCE = 400;

    private $id;
    private $futureCoordinates;
    private $targetId;
    private $timeToTarget = 100000;


    public function __construct(int $id, Coordinates $currentCoordinates, Coordinates $futureCoordinates, Human ...$humans)
    {
        parent::__construct($currentCoordinates);
        $this->id = $id;
        $this->futureCoordinates = $futureCoordinates;
        foreach($humans as $human){
            $killTime = ceil($this->distanceBetweenCharacters($human, $this) / self::MOVE_DISTANCE);
            if ($killTime < $this->timeToTarget){
                $this->timeToTarget = $killTime;
                $this->targetId = $human->getId();
            }
        }
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

    public function getTimeToTarget():int
    {
        return $this->timeToTarget;
    }

    public function getTargetId():int
    {
        return $this->targetId;
    }

    public function getFutureCoordinates(): Coordinates
    {
        return $this->futureCoordinates;
    }

}