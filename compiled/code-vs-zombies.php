<?php
namespace CodingGame\CodeVsZombies\Characters {
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
    public function getFutureCoordinates() : Coordinates
    {
        return $this->futureCoodinates;
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
    private function timeToReachCharacter(Character $character) : int
    {
        return ceil(($this->distanceBetweenCharacters($this, $character) - self::KILL_DISTANCE) / self::MOVE_DISTANCE);
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
use CodingGame\CodeVsZombies\Geometry\Coordinates;
abstract class Character
{
    /**
     * @var Coordinates
     */
    private $coordinates;
    /**
     * Character constructor.
     * @param Coordinates $coordinates
     * @internal param int $posX
     * @internal param int $posY
     */
    public function __construct(Coordinates $coordinates)
    {
        $this->coordinates = $coordinates;
    }
    /**
     * @return Coordinates
     */
    public function getCoordinates() : Coordinates
    {
        return $this->coordinates;
    }
    /**
     * @return mixed
     */
    public function getPosX() : int
    {
        return $this->coordinates->getX();
    }
    /**
     * @return mixed
     */
    public function getPosY() : int
    {
        return $this->coordinates->getY();
    }
}
}

namespace CodingGame\CodeVsZombies\Characters {
use CodingGame\CodeVsZombies\Geometry\Coordinates;
class Human extends Character implements Identifiable
{
    private $id;
    /**
     * Human constructor.
     * @param int $id
     * @param Coordinates $coordinates
     * @internal param int $posX
     * @internal param int $posY
     */
    public function __construct(int $id, Coordinates $coordinates)
    {
        parent::__construct($coordinates);
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
use CodingGame\CodeVsZombies\Geometry\Coordinates;
interface Moveable
{
    public function getFutureCoordinates() : Coordinates;
    public function getMoveDistance() : int;
}
}

namespace CodingGame\CodeVsZombies\Characters {
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
        foreach ($humans as $human) {
            $killTime = ceil($this->distanceBetweenCharacters($human, $this) / self::MOVE_DISTANCE);
            if ($killTime < $this->timeToTarget) {
                $this->timeToTarget = $killTime;
                $this->targetId = $human->getId();
            }
        }
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
    public function getFutureCoordinates() : Coordinates
    {
        return $this->futureCoordinates;
    }
}
}

namespace CodingGame\CodeVsZombies {
class DeathOrder
{
    private $deathOrder;
    public function __construct(Map $map)
    {
        foreach ($map->getZombies() as $zombie) {
            $this->deathOrder[$zombie->getTimeToTarget()][] = $zombie->getTargetId();
        }
        ksort($this->deathOrder);
    }
    public function get() : array
    {
        return $this->deathOrder;
    }
    public function getSoonestDeath()
    {
        return array_key_first($this->deathOrder);
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

namespace CodingGame\CodeVsZombies\Geometry {
class Coordinates
{
    /**
     * @var int
     */
    private $x;
    /**
     * @var int
     */
    private $y;
    /**
     * Coordinates constructor.
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }
    /**
     * @return int
     */
    public function getX() : int
    {
        return $this->x;
    }
    /**
     * @return int
     */
    public function getY() : int
    {
        return $this->y;
    }
}
}

namespace CodingGame\CodeVsZombies\Geometry {
use CodingGame\CodeVsZombies\Characters\Character;
trait Geometry
{
    function distanceBetweenCharacters(Character $char1, Character $char2) : float
    {
        return sqrt(pow($char1->getPosX() - $char2->getPosX(), 2) + pow($char1->getPosY() - $char2->getPosY(), 2));
    }
    function getCentroidCoordinates(Character ...$characters) : Coordinates
    {
        $xSum = 0;
        $ySum = 0;
        foreach ($characters as $character) {
            $xSum += $character->getPosX();
            $ySum += $character->getPosY();
        }
        return new Coordinates($xSum / count($characters), $ySum / count($characters));
    }
}
}

namespace CodingGame\CodeVsZombies {
use CodingGame\CodeVsZombies\Characters\Human;
use CodingGame\CodeVsZombies\Characters\Zombie;
class Map
{
    private $zombies;
    private $humans;
    private $deathOrder;
    public function __construct()
    {
        $this->deathOrder = [];
    }
    public function addZombie(Zombie $zombie)
    {
        $this->zombies[] = $zombie;
    }
    public function addHuman(Human $human)
    {
        $this->humans[] = $human;
    }
    public function getZombies() : array
    {
        return $this->zombies;
    }
    public function getHumans() : array
    {
        return $this->humans;
    }
    public function getHumanById(int $id) : Human
    {
        return $this->humans[$id];
    }
    public function getZombieById(int $id) : Zombie
    {
        return $this->zombies[$id];
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
use CodingGame\CodeVsZombies\Geometry\Coordinates;
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
            $map->addHuman(new Human($humanId, new Coordinates($humanX, $humanY)));
        }
        fscanf(STDIN, "%d", $zombieCount);
        for ($i = 0; $i < $zombieCount; $i++) {
            fscanf(STDIN, "%d %d %d %d %d", $zombieId, $zombieX, $zombieY, $zombieXNext, $zombieYNext);
            $zombie = new Zombie($zombieId, new Coordinates($zombieX, $zombieY), new Coordinates($zombieXNext, $zombieYNext), ...$map->getHumans());
            $map->addZombie($zombie);
        }
        $this->ash = new Ash(new Coordinates($x, $y), $map);
        $this->ash->determineMove();
    }
    /**
     * @return string Format "X Y" coordinate for Ash to move.
     *
     */
    public function response() : string
    {
        $coordinates = $this->ash->getFutureCoordinates();
        return $coordinates->getX() . " " . $coordinates->getY();
    }
    public function clearState()
    {
        $this->humans = [];
        $this->zombies = [];
    }
}
}

