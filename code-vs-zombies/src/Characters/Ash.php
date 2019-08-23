<?php


namespace CodingGame\CodeVsZombies\Characters;

use CodingGame\CodeVsZombies\Geometry\Geometry;
use CodingGame\CodeVsZombies\Map;

class Ash extends Character implements Moveable, Attacker
{
    use Geometry;
    private const MOVE_DISTANCE = 1000;
    private const KILL_DISTANCE = 2000;
    private $futureX;
    private $futureY;
    /**
     * @var Map
     */
    private $map;
    private $moveNotSet;

    /**
     * Ash constructor.
     * @param int $posX
     * @param int $posY
     * @param Map $map
     */
    public function __construct(int $posX, int $posY, Map $map)
    {
        parent::__construct($posX, $posY);
        $this->map = $map;
        $this->moveNotSet = true;
    }

    /**
     * @return int
     */
    public function getFutureX(): int
    {
        return $this->futureX;
    }

    /**
     * @return int
     */
    public function getFutureY(): int
    {
        return $this->futureY;
    }

    /**
     * @return int
     */
    public function getMoveDistance(): int
    {
        return self::MOVE_DISTANCE;
    }

    /**
     * @return int
     */
    public function getKillDistance(): int
    {
        return self::KILL_DISTANCE;
    }

    public function determineMove()
    {
        $this->targetLastZombie();
        if ($this->moveNotSet) {
            $this->betweenAllHumansAndZombies();
        }
        if ($this->moveNotSet) {
            $this->protectLastHuman();
        }
        if ($this->moveNotSet) {
            $this->saveClosestHumanToDeath();
        }
        if ($this->moveNotSet) {
            $this->targetLargestZombieCluster();
        }
    }

    private function targetLastZombie()
    {
        $zombies = $this->map->getZombies();
        if (count($zombies) === 1) {
            $zombie = reset($zombies);
            $this->futureX = $zombie->getPosX();
            $this->futureY = $zombie->getPosY();
            $this->moveNotSet = false;
        }
    }

    private function betweenAllHumansAndZombies()
    {
        $humans = $this->map->getHumans();
        $longestRescueTime = 0;
        foreach ($humans as $human) {
            $timeToReachHuman = $this->timeToReachCharacter($human);
            if ($longestRescueTime < $timeToReachHuman) {
                $longestRescueTime = $timeToReachHuman;
            }
        }
        if (array_key_first($this->map->getDeathOrder()) > $longestRescueTime) {
            $longestKillTime = 10000;
            $firstDeath = reset($this->map->getDeathOrder());
            foreach ($firstDeath as $zombies) {
                foreach ($zombies as $zombieId) {
                    $zombie = $this->map->getZombieById($zombieId);
                    $timeToReachZombie = $this->timeToReachCharacter($zombie);
                    if ($timeToReachZombie < $longestKillTime) {
                        $targetZombie = $zombie;
                        $longestKillTime = $timeToReachZombie;
                    }
                }
            }
            $this->futureX = $targetZombie->getPosX();
            $this->futureY = $targetZombie->getPosY();
            $this->moveNotSet = false;
        }
    }

    private function protectLastHuman()
    {
        $humans = $this->map->getHumans();
        if (count($humans) === 1) {
            $human = reset($humans);
            $this->futureX = $human->getPosX();
            $this->futureY = $human->getPosY();
        }
    }

    private function timeToReachCharacter(Character $character)
    {
        return ($this->distanceBetweenCharacters($this, $character) - 2000) / self::MOVE_DISTANCE;
    }

    private function saveClosestHumanToDeath()
    {
        $humanDeathOrder = $this->map->getDeathOrder();
        foreach ($humanDeathOrder as $timeToDeath => $humans) {
            foreach ($humans as $humanId => $zombiesTargetingHuman) {
                $human = $this->map->getHumanById($humanId);
                $timeToReachHuman = $this->timeToReachCharacter($human);
                if ($timeToDeath > $timeToReachHuman) {
                    $this->futureX = $human->getPosX();
                    $this->futureY = $human->getPosY();
                    $this->moveNotSet = false;
                    break 2;
                }
            }
        }
    }

    private function targetLargestZombieCluster()
    {
        $zombies = $this->map->getZombies();
        $largestCluster = 0;
        $targetCluster = [];
        foreach ($zombies as $zombie1) {
            $clusterSize = 0;
            $cluster = [];
            foreach ($zombies as $zombie2) {
                if ($this->distanceBetweenCharacters($zombie1, $zombie2) < self::KILL_DISTANCE) {
                    $cluster[] = $zombie2;
                    $clusterSize++;
                }
            }
            if ($clusterSize > $largestCluster) {
                $targetCluster = $cluster;
                $largestCluster = $clusterSize;
            }
        }
        $centroidCoordinates = $this->getCentroidCoordinates(...$targetCluster);
        $this->futureX = $centroidCoordinates['x'];
        $this->futureY = $centroidCoordinates['y'];
        $this->moveNotSet = false;
    }
}