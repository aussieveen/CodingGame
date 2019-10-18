<?php


namespace CodingGame\XmasRush\Item;

use CodingGame\XmasRush\Interfaces\Positionable;

class BoardItem extends Item implements Positionable
{
    /**
     * @var int
     */
    private $x;
    /**
     * @var int
     */
    private $y;

    /**
     * BoardItem constructor.
     * @param string $name
     * @param int $x
     * @param int $y
     * @param int $playerId
     */
    public function __construct(string $name, int $x, int $y, int $playerId)
    {
        $this->x = $x;
        $this->y = $y;

        parent::__construct($name, $playerId);
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @return bool
     */
    public function onPlayerTile(): bool
    {
        return $this->onUserTile(-1);
    }

    /**
     * @return bool
     */
    public function onOpponentTile(): bool
    {
        return $this->onUserTile(-2);
    }

    /**
     * @param $expectedValue
     * @return bool
     */
    private function onUserTile($expectedValue): bool
    {
        return $this->x === $expectedValue && $this->y === $expectedValue;
    }
}