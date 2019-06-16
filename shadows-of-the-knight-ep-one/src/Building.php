<?php


namespace CodeInGame\LegendsOfCodeMagic;


class Building
{
    private $widthRange;
    private $heightRange;

    /**
     * Building constructor.
     * @param int $width
     * @param int $height
     */
    public function __construct(int $width, int $height)
    {
        $this->widthRange = range(0, $width - 1);
        $this->heightRange = range(0, $height - 1);
    }

    /**
     * @return array
     */
    public function getWidthRange(): array
    {
        return $this->widthRange;
    }

    /**
     * @return array
     */
    public function getHeightRange(): array
    {
        return $this->heightRange;
    }

    public function updateWidthRange(int $removeFromIndex, int $upperOrLower): void {
        $this->widthRange = $this->updateRange($this->widthRange, $removeFromIndex, $upperOrLower);
    }

    public function updateHeightRange(int $removeFromIndex, int $upperOrLower): void{
        $this->heightRange = $this->updateRange($this->heightRange, $removeFromIndex, $upperOrLower);
    }

    public function getMiddleOfWidthRange(){
        return $this->widthRange[(int)floor(0 + (count($this->widthRange) - 0) / 2)];
    }

    public function getMiddleOfHeightRange(){
        return $this->heightRange[(int)floor(0 + (count($this->heightRange) - 0) / 2)];
    }

    private function updateRange(Array $range, int $removeFromIndex, int $upperOrLower):array {
        if ($key = array_search($removeFromIndex, $range)){
            if ($upperOrLower > 0){
                $range = array_slice($range, $key + 1 );
            }elseif ($upperOrLower < 0){
                $range = array_slice($range, 0 , $key);
            }
        }
        return $range;
    }




}