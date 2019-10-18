<?php


namespace CodingGame\XmasRush;


use CodingGame\XmasRush\Board\Board;
use CodingGame\XmasRush\Interfaces\Positionable;
use CodingGame\XmasRush\Item\BoardItemCollection;
use CodingGame\XmasRush\Item\Item;
use CodingGame\XmasRush\Item\ItemCollection;
use CodingGame\XmasRush\Item\QuestItemCollection;
use CodingGame\XmasRush\Player\Player;

class Game
{

    private const PUSH_TURN = 0;
    private const MOVE_TURN = 1;

    private const PLAYER_ID = 0;
    private const OPPONENT_ID = 1;

    private const PUSH_STRING_FORMAT = "PUSH %d %s\n";

    /**
     * @var Player
     */
    private $player;
    /**
     * @var Opponent
     */
    private $opponent;
    /**
     * @var Board
     */
    private $board;

    /**
     * @var int
     */
    private $turnType;
    /**
     * @var ItemCollection
     */
    private $boardItemCollection;
    /**
     * @var ItemCollection
     */
    private $questItemCollection;


    /**
     * Game constructor.
     * @param Player $player
     * @param Player $opponent
     */
    public function __construct(Player $player, Player $opponent)
    {
        $this->player = $player;
        $this->opponent = $opponent;

        $this->board = new Board();
        $this->boardItemCollection = new ItemCollection();
        $this->questItemCollection = new ItemCollection();
    }

    public function setTurnType(int $turnType): void
    {
        $this->turnType = $turnType;
    }

    public function getBoard() : Board
    {
        return $this->board;
    }

    public function getPlayer() : Player
    {
        return $this->player;
    }

    public function getOpponent() : Player
    {
        return $this->opponent;
    }

    public function getBoardItemCollection() : ItemCollection
    {
        return $this->boardItemCollection;
    }

    public function getQuestItemCollection() : ItemCollection
    {
        return $this->questItemCollection;
    }

    public function getPlayerActions() : string
    {
        return $this->turnType === self::PUSH_TURN ? $this->getPushTurn() : $this->getMoveTurn();
    }

    public function clear() : void
    {
        $this->board->clear();
        $this->boardItemCollection->clear();
        $this->questItemCollection->clear();
    }

    private function getPushTurn(): string
    {
        if ($this->playerHasQuestItemInPossession() && $this->positionableOnBoardEdge($this->player)){
            return $this->pushPositionableOffEdge($this->player);
        }

        $playerQuestItems = new QuestItemCollection();
        $playerBoardItems = new BoardItemCollection();

        foreach($this->questItemCollection as $questItem){
            if (!$this->isOpponentItem($questItem)){
                $playerQuestItems->add($questItem);
            }
        }

        foreach($this->getBoardItemCollection()->get() as $boardItem)
        {
            if (!$this->isOpponentItem($boardItem)){
                $playerBoardItems->add($boardItem);
            }
        }

        //MOVE REVEALLED QUEST ITEM FROM BOARD INTO POSSESSION
        foreach($playerQuestItems as $questItem)
        {
            foreach($playerBoardItems as $boardItem){
                if ($boardItem->getName() !== $questItem->getName()){
                    continue;
                }

                if ($this->positionableOnBoardEdge($boardItem)){
                    return $this->pushPositionableOffEdge($boardItem);
                }
            }
        }


        //MOVE REVEALLED QUEST ITEM INTO SHORTEST PATH

        //MOVE PLAYER COLLECTABLE ITEM INTO PATH

        //MOVE PLAYER QUEST REVEALLED BOARD ITEM TOWARDS EDGE
    }

    private function getMoveTurn() : string
    {
        //IF POSSESS ITEM, GET TO EDGE
        if ($this->playerHasQuestItemInPossession()){

            if ($this->player->getX() === 0 || $this->player->getY() === 0){
                return "PASS\n";
            }
        }

        //GET POSSIBLE PATH COORDS

        //COLLECT ITEMS

        //MOVE INTO POSITION WHERE PUSH TURN WORKS

        //MOVE A RANDOM DIRECTION??
        return "PASS\n";
    }

    private function isOpponentItem(Item $item): bool
    {
        return $item->getPlayerId() === self::OPPONENT_ID;
    }

    private function playerHasQuestItemInPossession(): bool
    {
        foreach ($this->boardItemCollection->get() as $boardItem) {
            if ($boardItem->onPlayerTile() && $boardItem->getPlayerId() === self::PLAYER_ID) {
                return true;
            }
        }
        return false;
    }

    private function positionableOnBoardEdge(Positionable $object){
        return in_array($object->getX(), [0,6], true) || in_array($object->getY(), [0,6], true);
    }

    private function pushPositionableOffEdge(Positionable $object): string {
        if (0 === $object->getX()) {
            return sprintf(self::PUSH_STRING_FORMAT, $object->getY(), 'LEFT');
        }

        if (6 === $object->getX()) {
            return sprintf(self::PUSH_STRING_FORMAT, $object->getY(), 'RIGHT');
        }

        if (0 === $object->getY()){
            return sprintf(self::PUSH_STRING_FORMAT, $object->getX(), 'UP');
        }

        if (6 === $object->getY()){
            return sprintf(self::PUSH_STRING_FORMAT, $object->getX(), 'DOWN');
        }
        return '';
    }
}