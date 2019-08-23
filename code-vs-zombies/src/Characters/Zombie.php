<?php


namespace CodingGame\CodeVsZombies\Characters;

use CodingGame\CodeVsZombies\Geometry\Geometry;


class Zombie extends Character implements Moveable, Identifiable, Attacker
{
    use Geometry;
    private const MOVE_DISTANCE = 400;
    private const KILL_DISTANCE = 0;
    private $id;
    private $futureX;
    private $futureY;
    private $targetId;
    private $timeToTarget = 100000;

    public function __construct(int $id, int $posX, int $posY, int $futureX, int $futureY, array $humans)
    {
        parent::__construct($posX, $posY);
        $this->id = $id;
        $this->futureX = $futureX;
        $this->futureY = $futureY;
        foreach ($humans as $human) {
            $killTime = ceil($this->distanceBetweenCharacters($human, $this) / self::MOVE_DISTANCE);
            if ($killTime < $this->timeToTarget) {
                $this->timeToTarget = $killTime;
                $this->targetId = $human->getId();
            }
        }
    }

    public function getFutureX(): int
    {
        return $this->futureX;
    }

    public function getFutureY(): int
    {
        return $this->futureY;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMoveDistance(): int
    {
        return self::MOVE_DISTANCE;
    }

    public function getKillDistance(): int
    {
        return self::KILL_DISTANCE;
    }

    public function getTimeToTarget(): int
    {
        return $this->timeToTarget;
    }

    public function getTargetId(): int
    {
        return $this->targetId;
    }
}