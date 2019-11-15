<?php


namespace CodingGame\XmasRush\Turns;

use CodingGame\XmasRush\Board\PathCollection;

class Move extends Turn
{
    public const ID = 1;

    /**
     * @var PathCollection
     */
    private $pathCollection;

    public function getTurn(): string
    {
        $playerPoint = $this->player->getPoint();
        //IF POSSESS ITEM, GET TO EDGE
        if ($this->hasQuestItemOnPossessedTile($this->player)){
            if ($playerPoint->getX() === 0 || $playerPoint->getY() === 0){
                return "PASS\n";
            }
        }

        $this->pathCollection = new PathCollection($this->board);
        $path = $this->pathCollection->getPathForPoint($playerPoint);

        $questItemsOnBoard = $this->getQuestItemsOnBoardForPlayer($this->player);
        if (!empty($questItemsOnBoard)){
            foreach($questItemsOnBoard as $boardItem){
                if ($path->isPointOnPath($boardItem->getPoint())){
                    $directions = $path->getDirectionsForPointAToPointB($playerPoint, $boardItem->getPoint());
                    if ($directions){
                        $output = 'MOVE';
                        $steps = explode(',', rtrim($directions,","), 20);
                        foreach($steps as $step){
                            $output .= ' ' . $step;
                        }
                        return $output . "\n";
                    }
                }
            }
        }


        //GET POSSIBLE PATH COORDS

        //COLLECT ITEMS

        //MOVE INTO POSITION WHERE PUSH TURN WORKS

        //MOVE A RANDOM DIRECTION??
        return "PASS\n";
    }
}