<?php


namespace CodingGame\CodeVsZombies;

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