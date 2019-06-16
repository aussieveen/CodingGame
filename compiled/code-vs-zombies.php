<?php
namespace CodingGame\CodeVsZombies\Characters {
use CodeInGame\LegendsOfCodeMagic\Debug;
use CodingGame\CodeVsZombies\Geometry;
class Ash extends Character implements Moveable, Attacker
{
    use Geometry;
    const MOVE_DISTANCE = 1000;
    const KILL_DISTANCE = 2000;
    private $futureX;
    private $futureY;
    /**
     * @var array
     */
    private $humans;
    /**
     * @var array
     */
    private $zombies;
    public function __construct(int $posX, int $posY, array $humans, array $zombies)
    {
        parent::__construct($posX, $posY);
        $this->humans = $humans;
        new Debug($humans);
        new Debug("");
        $this->zombies = $zombies;
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
        if (count($this->humans) === 1) {
            $this->futureX = $this->humans[0]->getPosX();
            $this->futureY = $this->humans[0]->getPosY();
            return;
        }
        $avoidableDeaths = $this->getAvoidableDeaths();
        $humanToSave = reset($avoidableDeaths);
        $this->futureX = $humanToSave->getPosX();
        $this->futureY = $humanToSave->getPosY();
    }
    private function getAvoidableDeaths()
    {
        $avoidableDeaths = [];
        foreach ($this->humans as $human) {
            $timeToRescue = $this->distanceBetweenPoints($this, $human) / self::MOVE_DISTANCE;
            foreach ($this->zombies as $zombie) {
                $timeToDeath = $this->distanceBetweenPoints($human, $zombie) / $zombie->getMoveDistance();
                switch ($timeToDeath <=> $timeToRescue) {
                    case 1:
                        $avoidableDeaths[$timeToDeath] = $human;
                    case -1:
                        continue 2;
                        break;
                }
            }
        }
        new Debug($avoidableDeaths);
        return $avoidableDeaths;
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

namespace CodingGame\CodeVsZombies {
use CodingGame\CodeVsZombies\Characters\Character;
trait Geometry
{
    function distanceBetweenPoints(Character $char1, Character $char2)
    {
        return sqrt(pow($char1->getPosX() + $char2->getPosX(), 2) + pow($char1->getPosY() + $char2->getPosY(), 2));
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
use CodingGame\CodeVsZombies\State;
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
        fscanf(STDIN, "%d %d", $x, $y);
        fscanf(STDIN, "%d", $humanCount);
        for ($i = 0; $i < $humanCount; $i++) {
            fscanf(STDIN, "%d %d %d", $humanId, $humanX, $humanY);
            $this->humans[] = new Human($humanId, $humanX, $humanY);
        }
        fscanf(STDIN, "%d", $zombieCount);
        for ($i = 0; $i < $zombieCount; $i++) {
            fscanf(STDIN, "%d %d %d %d %d", $zombieId, $zombieX, $zombieY, $zombieXNext, $zombieYNext);
            $this->zombies[] = new Zombie($zombieId, $zombieX, $zombieY, $zombieXNext, $zombieYNext);
        }
        $this->ash = new Ash($x, $y, $this->humans, $this->zombies);
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

