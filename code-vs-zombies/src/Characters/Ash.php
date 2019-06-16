<?php


namespace CodingGame\CodeVsZombies\Characters;

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

    public function getFutureX():int
    {
        return $this->futureX;
    }

    public function getFutureY():int
    {
        return $this->futureY;
    }

    public function getMoveDistance():int
    {
        return self::MOVE_DISTANCE;
    }

    public function getKillDistance():int
    {
        return self::KILL_DISTANCE;
    }

    public function determineMove(){
        if (count($this->humans) === 1){
            $this->futureX = $this->humans[0]->getPosX();
            $this->futureY = $this->humans[0]->getPosY();
            return;
        }

        $avoidableDeaths = $this->getAvoidableDeaths();
        $humanToSave = reset($avoidableDeaths);
        $this->futureX = $humanToSave->getPosX();
        $this->futureY = $humanToSave->getPosY();
    }

    private function getAvoidableDeaths(){
        $avoidableDeaths = [];
        foreach($this->humans as $human){
            $timeToRescue = $this->distanceBetweenPoints($this, $human) / self::MOVE_DISTANCE;
            foreach($this->zombies as $zombie){
                $timeToDeath = $this->distanceBetweenPoints($human, $zombie) / $zombie->getMoveDistance();
                switch($timeToDeath <=> $timeToRescue){
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