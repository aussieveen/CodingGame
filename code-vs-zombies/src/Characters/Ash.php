<?php


namespace CodingGame\CodeVsZombies\Characters;

use CodeInGame\CodeVsZombies\Debug;
use CodingGame\CodeVsZombies\DeathOrder;
use CodingGame\CodeVsZombies\Geometry\Coordinates;
use CodingGame\CodeVsZombies\Geometry\Geometry;
use CodingGame\CodeVsZombies\Map;

class Ash extends Character implements Moveable, Attacker
{

    use Geometry;

    const MOVE_DISTANCE = 1000;
    const KILL_DISTANCE = 2000;

    private $futureCoodinates;

    /**
     * @var Map
     */
    private $map;
    private $moveNotSet;
    private $deathOrder;

    /**
     * Ash constructor.
     * @param Coordinates $coordinates
     * @param Map $map
     * @internal param int $posX
     * @internal param int $posY
     */
    public function __construct(Coordinates $coordinates, Map $map)
    {
        parent::__construct($coordinates);
        $this->map = $map;
        $this->deathOrder = new DeathOrder($map);
        $this->moveNotSet = true;
    }


    public function getFutureCoordinates():Coordinates
    {
        return $this->futureCoodinates;
    }

    /**
     * @return int
     */
    public function getMoveDistance():int
    {
        return self::MOVE_DISTANCE;
    }

    /**
     * @return int
     */
    public function getKillDistance():int
    {
        return self::KILL_DISTANCE;
    }

    /**
     * Loops through strategy functions until the coordinates Ash should move to are set.
     */
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

    /**
     * Only one zombie lives. Kill it!
     */
    private function targetLastZombie()
    {
        $this->moveToLastCharacter(...$this->map->getZombies());
    }

    /**
     * Move to protect the last human on the map
     */
    private function protectLastHuman()
    {
        $this->moveToLastCharacter(...$this->map->getHumans());

    }

    /**
     * @param Character[] ...$characters
     */
    private function moveToLastCharacter(Character ...$characters)
    {
        if (count($characters) === 1) {
            $character = reset($characters);
            $this->futureCoodinates = $character->getCoordinates();
            $this->moveNotSet = false;
        }
    }

    /**
     * Determine if Ash is able to reach all humans before a zombie can. If so, target largest cluster of zombies
     */
    private function betweenAllHumansAndZombies()
    {
        $humans = $this->map->getHumans();
        $longestTimeToReachHuman = 0;
        foreach ($humans as $human) {
            $timeToReachHuman = $this->timeToReachCharacter($human);
            if ($longestTimeToReachHuman < $timeToReachHuman) {
                $longestTimeToReachHuman = $timeToReachHuman;
            }
        }

        if ($this->deathOrder->getSoonestDeath() > $longestTimeToReachHuman) {
            $this->targetLargestZombieCluster();
        }
    }

    /**
     * Move towards the human nearest to death that can be saved.
     */
    private function saveClosestHumanToDeath()
    {
        foreach ($this->deathOrder->get() as $timeToDeath => $humanIds) {
            foreach ($humanIds as $humanId) {
                $human = $this->map->getHumanById($humanId);
                $timeToReachHuman = $this->timeToReachCharacter($human);
                if ($timeToDeath >= $timeToReachHuman) {
                    $this->futureCoodinates = $human->getCoordinates();
                    $this->moveNotSet = false;
                    break 2;
                }
            }
        }
    }

    /**
     * Get the central point of the largest zombie cluster and move towards it.
     */
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

        $this->futureCoodinates = $this->getCentroidCoordinates(...$targetCluster);
        $this->moveNotSet = false;
    }

    /**
     * @param Character $character
     * @return int
     */
    private function timeToReachCharacter(Character $character):int
    {
        return ceil(($this->distanceBetweenCharacters($this, $character) - self::KILL_DISTANCE) / self::MOVE_DISTANCE);
    }

}