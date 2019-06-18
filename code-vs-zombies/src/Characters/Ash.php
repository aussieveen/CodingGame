<?php


namespace CodingGame\CodeVsZombies\Characters;

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
        $humans = $this->map->getHumans();
        $zombies = $this->map->getZombies();
        foreach([$humans,$zombies] as $characters){
            if (count($characters) === 1){
                $this->futureX = $characters[0]->getPosX();
                $this->futureY = $characters[0]->getPosY();

                return;
            }
        }

        $humanDeathOrder = $this->map->getDeathOrder();
        foreach($humanDeathOrder as $timeToDeath => $humans){
            foreach($humans as $human) {
                $timeToRescue = (($this->distanceBetweenPoints($this, $human)) - 2000) / self::MOVE_DISTANCE;
                if ($timeToDeath > $timeToRescue) {
                    $this->futureX = $human->getPosX();
                    $this->futureY = $human->getPosY();
                    break 2;
                }
            }
        }
    }

}