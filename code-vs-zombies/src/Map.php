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
        $this->zombies[] = $zombie;
    }

    public function addHuman(Human $human)
    {
        $this->humans[] = $human;
    }

    public function getZombies():array
    {
        return $this->zombies;
    }

    public function getHumans():array
    {
        return $this->humans;
    }

    public function getHumanById(int $id): Human
    {
        return $this->humans[$id];
    }

    public function getZombieById(int $id): Zombie{
        return $this->zombies[$id];
    }



}