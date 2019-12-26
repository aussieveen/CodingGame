<?php


namespace CodingGame\XmasRush;


use CodingGame\XmasRush\Board\Board;
use CodingGame\XmasRush\Item\BoardItem;
use CodingGame\XmasRush\Item\BoardItemCollection;
use CodingGame\XmasRush\Item\Item;
use CodingGame\XmasRush\Item\QuestItemCollection;
use CodingGame\XmasRush\Player\Player;
use CodingGame\XmasRush\Turns\Move;
use CodingGame\XmasRush\Turns\Push;

class Game
{

    /**
     * @var Player
     */
    private $player;
    /**
     * @var Player
     */
    private $opponent;
    /**
     * @var Board
     */
    private $board;

    /**
     * @var Push
     */
    private $action;


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
    }

    public function setActionType(int $actionType): void
    {
        switch($actionType){
            case Push::ID:
                $this->action = new Push($this->board,$this->player, $this->opponent);
                break;
            case Move::ID;
                $this->action = new Move($this->board,$this->player, $this->opponent);
                break;
        }
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

    public function setBoardItems(BoardItem ...$boardItems):void
    {
        foreach($boardItems as $boardItem) {
            if ($boardItem->inPossession()){
                $boardItemPoint = $boardItem->getPoint();
                ($boardItemPoint->getX() === -1 && $boardItemPoint->getY() === -1) ?
                    $this->player->setBoardItem($boardItem) :
                    $this->opponent->setBoardItem($boardItem);
            }else {
                $this->board->setBoardItem($boardItem);
            }
        }

    }

    public function setQuestItems(Item ...$questItems):void
    {
        $playerQuestItemCollection = new QuestItemCollection();
        $opponentQuestItemCollection = new QuestItemCollection();
        foreach($questItems as $questItem){
            if($questItem->getPlayerId() === $this->player->getId()){
                $playerQuestItemCollection->add($questItem);
            }else{
                $opponentQuestItemCollection->add($questItem);
            }
        }
        $this->player->setQuestItems($playerQuestItemCollection);
        $this->opponent->setQuestItems($opponentQuestItemCollection);
    }

    public function getPlayerAction() : string
    {
        return $this->action->getAction();
    }

    public function clear() : void
    {
        $this->board->clear();
    }





}