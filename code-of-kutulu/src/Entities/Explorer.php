<?php


namespace CodingGame\CodeOfKutulu\Entities;


use CodingGame\CodeOfKutulu\Coordinates;

class Explorer extends Entity implements Identifiable, Positionable
{
    private $id;
    private $coordinates;
    private $sanity;
    private $plans;
    private $lights;


    /**
     * Explorer constructor.
     * @param int $id
     * @param int $xPos
     * @param int $yPos
     * @param int $sanity
     * @param int $plans
     * @param int $lights
     */
    public function __construct(int $id, int $xPos, int $yPos, int $sanity, int $plans, int $lights)
    {

        $this->id = $id;
        $this->coordinates = new Coordinates($xPos, $yPos);
        $this->sanity = $sanity;
        $this->plans = $plans;
        $this->lights = $lights;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getX():int
    {
        return $this->coordinates->getX();
    }

    public function getY():int
    {
        return $this->coordinates->getY();
    }

    public function getSanity()
    {
        return $this->sanity;
    }

    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }

    public function getPlans(): int
    {
        return $this->plans;
    }

    public function getLights(): int
    {
        return $this->lights;
    }

}