<?php


namespace CodingGame\CodeVsZombies;


use CodingGame\CodeVsZombies\Characters\Ash;
use CodingGame\CodeVsZombies\Characters\Human;
use CodingGame\CodeVsZombies\Characters\Zombie;

class Game
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
    public function response(): string
    {
        return $this->ash->getFutureX() . ' ' . $this->ash->getFutureY();
    }

    public function clearState()
    {
        $this->humans = [];
        $this->zombies = [];
    }
}