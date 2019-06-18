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
    }
    public function getFutureX() : int
    {
        return $this->futureX;
    }
    public function getFutureY() : int
    {
        return $this->futureY;
    }
    public function getMoveDistance() : int
    {
        return self::MOVE_DISTANCE;
    }
    public function getKillDistance() : int
    {
        return self::KILL_DISTANCE;
    }
    public function determineMove()
    {
        $humans = $this->map->getHumans();
        $zombies = $this->map->getZombies();
        foreach ([$humans, $zombies] as $characters) {
            if (count($characters) === 1) {
                $this->futureX = $characters[0]->getPosX();
                $this->futureY = $characters[0]->getPosY();
                return;
            }
        }
        $humanDeathOrder = $this->map->getDeathOrder();
        foreach ($humanDeathOrder as $timeToDeath => $humans) {
            foreach ($humans as $human) {
                $timeToRescue = ($this->distanceBetweenPoints($this, $human) - 2000) / self::MOVE_DISTANCE;
                if ($timeToDeath > $timeToRescue) {
                    $this->futureX = $human->getPosX();
                    $this->futureY = $human->getPosY();
                    break 2;
                }
            }
        }
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
     * @param int $id
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
    public function setId(int $id) : void
    {
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
    public function setId(int $id) : void;
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
    public function getFutureX() : int
    {
        return $this->futureX;
    }
    public function getFutureY() : int
    {
        return $this->futureY;
    }
    public function setId(int $id) : void
    {
        $this->id = $id;
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
}
}

namespace CodeInGame\LegendsOfCodeMagic {
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
    function distanceBetweenPoints(Character $char1, Character $char2) : float
    {
        return sqrt(pow($char1->getPosX() - $char2->getPosX(), 2) + pow($char1->getPosY() - $char2->getPosY(), 2));
    }
}
}

namespace CodingGame\CodeVsZombies {
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
        $this->zombies[] = $zombie;
    }
    public function addHuman(Human $human)
    {
        $this->humans[] = $human;
    }
    public function calculateDeathOrder() : void
    {
        foreach ($this->zombies as $zombie) {
            $timeToTarget = 1000000;
            foreach ($this->humans as $human) {
                $killTime = ceil($this->distanceBetweenPoints($human, $zombie) / $zombie->getMoveDistance());
                if ($killTime < $timeToTarget) {
                    $timeToTarget = $killTime;
                    $targetHuman = $human;
                }
                $this->deathOrder[$timeToTarget][] = $targetHuman;
            }
        }
        ksort($this->deathOrder);
    }
    public function getDeathOrder()
    {
        $this->calculateDeathOrder();
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
            $map->addZombie(new Zombie($zombieId, $zombieX, $zombieY, $zombieXNext, $zombieYNext));
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

