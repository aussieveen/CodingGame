<?php


namespace CodingGame\CodeOfKutulu\Entities\Effects;


use CodingGame\CodeOfKutulu\Coordinates;
use CodingGame\CodeOfKutulu\Entities\Entity;
use CodingGame\CodeOfKutulu\Entities\Identifiable;
use CodingGame\CodeOfKutulu\Entities\Positionable;

class Plan extends Entity implements Effect, Identifiable, Positionable
{

    const RANGE = 2;

    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $turnsRemaining;
    /**
     * @var int
     */
    private $explorerId;
    /**
     * @var Coordinates
     */
    private $coordinates;


    /**
     * Plan constructor.
     * @param int $id
     * @param int $x
     * @param int $y
     * @param int $turnsRemaining
     * @param int $explorerId
     */
    public function __construct(int $id, int $x, int $y, int $turnsRemaining, int $explorerId)
    {
        $this->id = $id;
        $this->coordinates = new Coordinates($x, $y);
        $this->turnsRemaining = $turnsRemaining;
        $this->explorerId = $explorerId;
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

    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }

    public function getTurnsRemaining(): int
    {
        return $this->turnsRemaining;
    }

    public function getRange(): int
    {
        return self::RANGE;
    }
}