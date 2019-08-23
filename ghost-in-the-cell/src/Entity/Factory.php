<?php


namespace CodeInGame\GhostInTheCell\Entity;


class Factory
{
    /**
     * @var array
     */
    private $links;
    private $troops;
    private $bombs;
    private $owner;
    private $cyborgs;
    private $production;
    private $delay;
    private $arg5;

    /**
     * Factory constructor.
     * @param array $links
     */
    public function __construct(array $links)
    {
        $this->links = $links;
    }

    public function update(int $owner, int $cyborgs, int $production, int $delay, $arg5)
    {
        $this->owner = $owner;
        $this->cyborgs = $cyborgs;
        $this->production = $production;
        $this->delay = $delay;
        $this->arg5 = $arg5;
        $this->troops = [];
        $this->bombs = [];
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @return mixed
     */
    public function getTroops()
    {
        return $this->troops;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return mixed
     */
    public function getCyborgs()
    {
        return $this->cyborgs;
    }

    /**
     * @return mixed
     */
    public function getProduction()
    {
        return $this->production;
    }

    /**
     * @return mixed
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * @return mixed
     */
    public function getArg5()
    {
        return $this->arg5;
    }

    /**
     * @param Troop $troop
     */
    public function incomingTroop(Troop $troop)
    {
        $this->troops[] = $troop;
    }

    public function incomingBomb(Bomb $bomb)
    {
        $this->bombs[] = $bomb;
    }



}