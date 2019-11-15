<?php


namespace CodingGame\XmasRush\Turns;

use CodingGame\XmasRush\Board\Board;
use CodingGame\XmasRush\Interfaces\Positionable;
use CodingGame\XmasRush\Item\BoardItemCollection;
use CodingGame\XmasRush\Player\Player;

abstract class Turn
{
    /**
     * @var Board
     */
    protected $board;
    /**
     * @var Player
     */
    protected $player;
    /**
     * @var Opponent
     */
    protected $opponent;

    public function __construct(Board $board, Player $player, Player $opponent){

        $this->board = $board;
        $this->player = $player;
        $this->opponent = $opponent;
    }

    abstract public function getTurn(): string;

    protected function hasQuestItemOnPossessedTile(Player $player): bool
    {
        $boardItems = $player->getBoardItems();
        $questItems = $player->getQuestItems();
        foreach($boardItems as $boardItem){
            if (!$boardItem->inPossession()){
                continue;
            }
            foreach($questItems as $questItem){
                if ($questItem->getName() === $boardItem->getName()){
                    return true;
                }
            }
            return false;
        }
        return false;
    }

    protected function getQuestItemsOnBoardForPlayer(Player $player): BoardItemCollection
    {
        $questOnBoardItems = new BoardItemCollection();
        foreach($player->getQuestItems() as $playerQuestItem){
            foreach($player->getBoardItems() as $playerBoardItem){
                if ($playerBoardItem->getName() === $playerQuestItem->getName()){
                    $questOnBoardItems->add($playerBoardItem);
                    continue 2;
                }
            }
        }
        return $questOnBoardItems;
    }

    protected function positionableOnBoardEdge(Positionable $object): bool
    {
        $point = $object->getPoint();
        return in_array($point->getX(), [0,6], true) || in_array($point->getY(), [0,6], true);
    }

}