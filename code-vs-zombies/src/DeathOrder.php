<?php


namespace CodingGame\CodeVsZombies;


use CodeInGame\CodeVsZombies\Debug;

class DeathOrder
{
    private $deathOrder;

    public function __construct(Map $map)
    {
        foreach($map->getZombies() as $zombie){
            $this->deathOrder[$zombie->getTimeToTarget()][] = $zombie->getTargetId();
        }
        ksort($this->deathOrder);
    }

    public function get(): array
    {
        return $this->deathOrder;
    }

    public function getSoonestDeath(){
        return array_key_first($this->deathOrder);
    }
}