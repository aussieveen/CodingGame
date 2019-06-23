<?php
namespace CodingGame\CodeVsZombies\Characters {
use CodingGame\CodeVsZombies\Geometry;
use CodingGame\CodeVsZombies\Map;
class Ash extends Character implements Moveable, Attacker
{
    use Geometry;
    const MOVE_DISTANCE = 1000;
    const KILL_DISTANCE = 2000;
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
    public function getFutureX() : int
    {
        return $this->futureX;
    }
    /**
     * @return int
     */
    public function getFutureY() : int
    {
        return $this->futureY;
    }
    /**
     * @return int
     */
    public function getMoveDistance() : int
    {
        return self::MOVE_DISTANCE;
    }
    /**
     * @return int
     */
    public function getKillDistance() : int
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
}

namespace CodingGame\CodeVsZombies\Characters {
interface Attacker
{
    public function getKillDistance() : int;
}
}

namespace CodingGame\CodeVsZombies\Characters {
abstract class Character
{
    private $posX;
    private $posY;
    /**
     * Character constructor.
     * @param int $posX
     * @param int $posY
     */
    public function __construct(int $posX, int $posY)
    {
        $this->posX = $posX;
        $this->posY = $posY;
    }
    /**
     * @return mixed
     */
    public function getPosY() : int
    {
        return $this->posY;
    }
    /**
     * @return mixed
     */
    public function getPosX() : int
    {
        return $this->posX;
    }
}
}

namespace CodingGame\CodeVsZombies\Characters {
class Human extends Character implements Identifiable
{
    private $id;
    /**
     * Human constructor.
     * @param int $id
     * @param int $posX
     * @param int $posY
     */
    public function __construct(int $id, int $posX, int $posY)
    {
        parent::__construct($posX, $posY);
        $this->id = $id;
    }
    public function getId() : int
    {
        return $this->id;
    }
}
}

namespace CodingGame\CodeVsZombies\Characters {
interface Identifiable
{
    public function getId() : int;
}
}

namespace CodingGame\CodeVsZombies\Characters {
interface Moveable
{
    public function getFutureX() : int;
    public function getFutureY() : int;
    public function getMoveDistance() : int;
}
}

namespace CodingGame\CodeVsZombies\Characters {
use CodingGame\CodeVsZombies\Geometry;
class Zombie extends Character implements Moveable, Identifiable, Attacker
{
    use Geometry;
    const MOVE_DISTANCE = 400;
    const KILL_DISTANCE = 400;
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
    public function getFutureX() : int
    {
        return $this->futureX;
    }
    public function getFutureY() : int
    {
        return $this->futureY;
    }
    public function getId() : int
    {
        return $this->id;
    }
    public function getMoveDistance() : int
    {
        return self::MOVE_DISTANCE;
    }
    public function getKillDistance() : int
    {
        return self::KILL_DISTANCE;
    }
    public function getTimeToTarget() : int
    {
        return $this->timeToTarget;
    }
    public function getTargetId() : int
    {
        return $this->targetId;
    }
}
}

namespace CodeInGame\CodeVsZombies {
class Debug
{
    public function __construct($item)
    {
        error_log(var_export($item, true));
    }
}
}

namespace CodingGame\CodeVsZombies {
use CodingGame\CodeVsZombies\Characters\Character;
trait Geometry
{
    function distanceBetweenCharacters(Character $char1, Character $char2) : float
    {
        return sqrt(pow($char1->getPosX() - $char2->getPosX(), 2) + pow($char1->getPosY() - $char2->getPosY(), 2));
    }
    function getCentroidCoordinates(Character ...$characters)
    {
        $xSum = 0;
        $ySum = 0;
        foreach ($characters as $character) {
            $xSum += $character->getPosX();
            $ySum += $character->getPosY();
        }
        return ['x' => $xSum / count($characters), 'y' => $ySum / count($characters)];
    }
}
}

namespace CodingGame\CodeVsZombies {
use CodeInGame\CodeVsZombies\Debug;
use CodingGame\CodeVsZombies\Characters\Human;
use CodingGame\CodeVsZombies\Characters\Zombie;
class Map
{
    use Geometry;
    private $zombies;
    private $humans;
    private $deathOrder;
    public function __construct()
    {
        $this->deathOrder = [];
    }
    public function addZombie(Zombie $zombie)
    {
        $this->zombies[$zombie->getId()] = $zombie;
    }
    public function addHuman(Human $human)
    {
        $this->humans[$human->getId()] = $human;
    }
    public function getDeathOrder()
    {
        if (empty($this->deathOrder)) {
            $this->calculateDeathOrder();
        }
        return $this->deathOrder;
    }
    public function getZombies() : array
    {
        return $this->zombies;
    }
    public function getHumans() : array
    {
        return $this->humans;
    }
    private function calculateDeathOrder() : void
    {
        foreach ($this->zombies as $zombieId => $zombie) {
            $this->deathOrder[$zombie->getTimeToTarget()][$zombie->getTargetId()][] = $zombieId;
        }
        ksort($this->deathOrder);
    }
    public function getHumanById(int $id)
    {
        return $this->humans[$id] ?? false;
    }
    public function getZombieById(int $id)
    {
        return $this->zombies[$id] ?? false;
    }
}
}

namespace CodingGame\CodeVsZombies {
$state = new State();
// game loop
while (TRUE) {
    $state->clearState();
    $state->update();
    echo $state->response() . "\n";
}
}

namespace CodingGame\CodeVsZombies {
use CodingGame\CodeVsZombies\Characters\Ash;
use CodingGame\CodeVsZombies\Characters\Human;
use CodingGame\CodeVsZombies\Characters\Zombie;
class State
{
    private $ash;
    private $humans;
    private $zombies;
    public function update()
    {
        $map = new Map();
        fscanf(STDIN, "%d %d", $x, $y);
        fscanf(STDIN, "%d", $humanCount);
        for ($i = 0; $i < $humanCount; $i++) {
            fscanf(STDIN, "%d %d %d", $humanId, $humanX, $humanY);
            $map->addHuman(new Human($humanId, $humanX, $humanY));
        }
        fscanf(STDIN, "%d", $zombieCount);
        for ($i = 0; $i < $zombieCount; $i++) {
            fscanf(STDIN, "%d %d %d %d %d", $zombieId, $zombieX, $zombieY, $zombieXNext, $zombieYNext);
            $zombie = new Zombie($zombieId, $zombieX, $zombieY, $zombieXNext, $zombieYNext, $map->getHumans());
            $map->addZombie($zombie);
        }
        $this->ash = new Ash($x, $y, $map);
        $this->ash->determineMove();
    }
    /**
     * @return string Format "X Y" coordinate for Ash to move.
     *
     */
    public function response() : string
    {
        return $this->ash->getFutureX() . " " . $this->ash->getFutureY();
    }
    public function clearState()
    {
        $this->humans = [];
        $this->zombies = [];
    }
}
}

