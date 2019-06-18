<?php


namespace CodingGame\CodeVsZombies;

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

    public function calculateDeathOrder():void
    {
        foreach($this->zombies as $zombie){
            $timeToTarget = 1000000;
            foreach($this->humans as $human){
                $killTime = ceil($this->distanceBetweenPoints($human, $zombie) / $zombie->getMoveDistance());
                if ($killTime < $timeToTarget){
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

    public function getZombies():array
    {
        return $this->zombies;
    }

    public function getHumans():array
    {
        return $this->humans;
    }

}