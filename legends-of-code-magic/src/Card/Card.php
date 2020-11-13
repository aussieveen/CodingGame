<?php

namespace CodingGame\LegendsOfCodeMagic\Card;

class Card
{
    /**
     * @var int
     */
    private $instanceId;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $cost;

    /**
     * @var int
     */
    private $attack;

    /**
     * @var int
     */
    private $health;

    /**
     * @var string
     */
    private $abilities;

    /**
     * @var int
     */
    private $ownerHealthChange;

    /**
     * @var int
     */
    private $opponentHealthChange;

    /**
     * @var int
     */
    private $draw;

    public function __construct(
        int $instanceId,
        int $id,
        string $name,
        string $type,
        int $cost,
        int $attack,
        int $health,
        string $abilities,
        int $ownerHealthChange,
        int $opponentHealthChange,
        int $draw
    )
    {
        $this->instanceId = $instanceId;
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->cost = $cost;
        $this->attack = $attack;
        $this->health = $health;
        $this->abilities = $abilities;
        $this->ownerHealthChange = $ownerHealthChange;
        $this->opponentHealthChange = $opponentHealthChange;
        $this->draw = $draw;
    }

    /**
     * @return int
     */
    public function getInstanceId(): int
    {
        return $this->instanceId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getCost(): int
    {
        return $this->cost;
    }

    /**
     * @return int
     */
    public function getAttack(): int
    {
        return $this->attack;
    }

    /**
     * @return int
     */
    public function getHealth(): int
    {
        return $this->health;
    }

    /**
     * @return string
     */
    public function getAbilities(): string
    {
        return $this->abilities;
    }

    /**
     * @return int
     */
    public function getOwnerHealthChange(): int
    {
        return $this->ownerHealthChange;
    }

    /**
     * @return int
     */
    public function getOpponentHealthChange(): int
    {
        return $this->opponentHealthChange;
    }

    /**
     * @return int
     */
    public function getDraw(): int
    {
        return $this->draw;
    }


}