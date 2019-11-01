<?php

namespace CodingGame\XmasRush\Item;

class Item
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $playerId;

    /**
     * Item constructor.
     * @param string $name
     * @param int $playerId
     */
    public function __construct(string $name, int $playerId)
    {
        $this->name = $name;
        $this->playerId = $playerId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPlayerId(): int
    {
        return $this->playerId;
    }
}