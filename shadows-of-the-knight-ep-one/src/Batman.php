<?php


namespace CodeInGame\LegendsOfCodeMagic;


class Batman
{
    /**
     * @var int
     */
    private $posX;
    /**
     * @var int
     */
    private $posY;
    /**
     * @var Building
     */
    private $building;

    /**
     * Batman constructor.
     * @param Building $building
     * @param int $posX
     * @param int $posY
     */
    public function __construct(Building $building, int $posX, int $posY)
    {
        $this->posX = $posX;
        $this->posY = $posY;
        $this->building = $building;
    }

    public function move(int $horizontal, int $vertical){
        $this->building->updateWidthRange($this->posX, $horizontal);
        $this->building->updateHeightRange($this->posY, $vertical);
        $this->posX = $this->building->getMiddleOfWidthRange();
        $this->posY = $this->building->getMiddleOfHeightRange();
    }

    /**
     * @return int
     */
    public function getPosX(): int
    {
        return $this->posX;
    }

    /**
     * @return int
     */
    public function getPosY(): int
    {
        return $this->posY;
    }


}