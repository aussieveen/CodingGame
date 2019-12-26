<?php


namespace CodingGame\XmasRush\Turns;

use CodingGame\XmasRush\Board\Board;
use CodingGame\XmasRush\Board\PathCollection;
use CodingGame\XmasRush\Interfaces\Positionable;
use CodingGame\XmasRush\Item\BoardItemCollection;
use CodingGame\XmasRush\Player\Player;

abstract class Action
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
    /**
     * @var PathCollection
     */
    protected $pathCollection;

    public function __construct(Board $board, Player $player, Player $opponent)
    {

        $this->board = $board;
        $this->player = $player;
        $this->opponent = $opponent;
        $this->pathCollection = new PathCollection($this->board);
    }

    abstract public function getAction(): string;

    protected function hasQuestItemOnPossessedTile(Player $player): bool
    {
        $boardItem = $player->getBoardItem();
        if (null === $boardItem){
            return false;
        }
        $questItems = $player->getQuestItems();
        foreach ($questItems as $questItem) {
            if ($questItem->getName() === $boardItem->getName()) {
                return true;
            }
        }
        return false;
    }

    protected function getQuestItemsOnBoardForPlayer(Player $player): BoardItemCollection
    {
        $questOnBoardItems = new BoardItemCollection();
        foreach ($player->getQuestItems() as $playerQuestItem) {
            foreach ($this->board->getItemsOnBoard() as $boardItem) {
                if ($boardItem->getName() === $playerQuestItem->getName() &&
                    $boardItem->getPlayerId() === $player->getId()) {
                    $questOnBoardItems->add($boardItem);
                    continue 2;
                }
            }
        }
        return $questOnBoardItems;
    }

    protected function positionableOnBoardEdge(Positionable $object): bool
    {
        $point = $object->getPoint();
        return in_array($point->getX(), [0, 6], true) || in_array($point->getY(), [0, 6], true);
    }
}