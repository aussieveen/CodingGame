<?php


namespace CodingGame\XmasRush\Turns;

use CodingGame\XmasRush\Interfaces\Positionable;

class Push extends Turn
{
    public const ID = 0;

    private const PUSH_STRING_FORMAT = "PUSH %d %s\n";

    public function getTurn(): string
    {
        if ($this->hasQuestItemOnPossessedTile($this->player) && $this->positionableOnBoardEdge($this->player)){
            return $this->pushPositionableOffEdge($this->player);
        }

        //MOVE REVEALLED QUEST ITEM FROM BOARD INTO POSSESSION
        $items = $this->getQuestItemsOnBoardForPlayer($this->player);
        foreach($items as $item)
        {
                if ($this->positionableOnBoardEdge($item)){
                    return $this->pushPositionableOffEdge($item);
                }
        }

        //MOVE PLAYER ONTO COLLECTABLE ITEM PATH


        //MOVE PLAYER COLLECTABLE ITEM INTO PATH

        //MOVE PLAYER QUEST REVEALLED BOARD ITEM TOWARDS EDGE

        //MOVE OPPONENT PLAYER ITEM OUT OF THEIR PATH

        return "PUSH 1 DOWN\n";
    }

    private function pushPositionableOffEdge(Positionable $object): string {
        $point = $object->getPoint();
        if (0 === $point->getX()) {
            return sprintf(self::PUSH_STRING_FORMAT, $point->getY(), 'LEFT');
        }

        if (6 === $point->getX()) {
            return sprintf(self::PUSH_STRING_FORMAT, $point->getY(), 'RIGHT');
        }

        if (0 === $point->getY()){
            return sprintf(self::PUSH_STRING_FORMAT, $point->getX(), 'UP');
        }

        if (6 === $point->getY()){
            return sprintf(self::PUSH_STRING_FORMAT, $point->getX(), 'DOWN');
        }
        return '';
    }
}