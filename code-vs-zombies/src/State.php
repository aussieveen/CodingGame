<?php


namespace CodingGame\CodeVsZombies;


use CodingGame\CodeVsZombies\Characters\Ash;
use CodingGame\CodeVsZombies\Characters\Human;
use CodingGame\CodeVsZombies\Characters\Zombie;
use CodingGame\CodeVsZombies\Geometry\Coordinates;

class State
{

    private $ash;
    private $humans;
    private $zombies;

    public function update(){

        $map = new Map();
        fscanf(STDIN, "%d %d",
            $x,
            $y
        );

        fscanf(STDIN, "%d",
            $humanCount
        );
        for ($i = 0; $i < $humanCount; $i++)
        {
            fscanf(STDIN, "%d %d %d",
                $humanId,
                $humanX,
                $humanY
            );
            $map->addHuman(new Human($humanId, new Coordinates($humanX,$humanY)));
        }

        fscanf(STDIN, "%d",
            $zombieCount
        );
        for ($i = 0; $i < $zombieCount; $i++)
        {
            fscanf(STDIN, "%d %d %d %d %d",
                $zombieId,
                $zombieX,
                $zombieY,
                $zombieXNext,
                $zombieYNext
            );
            $zombie = new Zombie($zombieId,new Coordinates($zombieX,$zombieY),new Coordinates($zombieXNext, $zombieYNext), ...$map->getHumans());
            $map->addZombie($zombie);
        }

        $this->ash = new Ash(new Coordinates($x, $y), $map);
        $this->ash->determineMove();
    }

    /**
     * @return string Format "X Y" coordinate for Ash to move.
     *
     */
    public function response(): string
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