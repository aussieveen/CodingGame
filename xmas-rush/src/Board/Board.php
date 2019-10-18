<?php


namespace CodingGame\XmasRush\Board;


class Board
{
    private $state = [];

    /**
     * @param int $row
     * @param int $column
     * @param Tile $tile
     */
    public function set(int $row, int $column, Tile $tile): void
    {
        $this->state[$row][$column] = $tile;
    }

    /**
     * @param int $row
     * @param int $column
     * @return Tile
     */
    public function get(int $row, int $column) : Tile
    {
        return $this->state[$row][$column];
    }

    public function clear(): void
    {
        $this->state = [];
    }
}