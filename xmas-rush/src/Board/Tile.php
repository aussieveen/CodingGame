<?php


namespace CodingGame\XmasRush\Board;


class Tile
{
    private $upPath;
    private $rightPath;
    private $downPath;
    private $leftPath;

    /**
     * Tile constructor.
     * @param string $representation
     */
    public function __construct(string $representation)
    {
        $arrayRep = str_split($representation);
        $this->upPath = $arrayRep[0] === '1';
        $this->rightPath = $arrayRep[1] === '1';
        $this->downPath = $arrayRep[2] === '1';
        $this->leftPath = $arrayRep[3] === '1';
    }

    /**
     * @return bool
     */
    public function hasUpPath() : bool
    {
        return $this->upPath;
    }

    /**
     * @return bool
     */
    public function hasRightPath() : bool
    {
        return $this->rightPath;
    }

    /**
     * @return bool
     */
    public function hasDownPath() : bool
    {
        return $this->downPath;
    }

    /**
     * @return bool
     */
    public function hasLeftPath() : bool
    {
        return $this->leftPath;
    }
}