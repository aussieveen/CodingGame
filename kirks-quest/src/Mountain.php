<?php

namespace CodingGame\KirksQuests;


class Mountain
{
    /**
     * @var int
     */
    private $height;
    /**
     * @var int
     */
    private $position;

    public function __construct(int $height, int $position)
    {
        $this->height = $height;
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }


}