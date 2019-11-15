<?php


namespace CodingGame\XmasRush;


use CodingGame\XmasRush\Board\Board;
use CodingGame\XmasRush\Board\PathCollection;
use CodingGame\XmasRush\Interfaces\Positionable;
use CodingGame\XmasRush\Item\BoardItem;
use CodingGame\XmasRush\Item\BoardItemCollection;
use CodingGame\XmasRush\Item\Item;
use CodingGame\XmasRush\Item\QuestItemCollection;
use CodingGame\XmasRush\Player\Opponent;
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
     * @var Opponent
     */
    private $opponent;
    /**
     * @var Board
     */
    private $board;

    /**
     * @var Push
     */
    private $turn;


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

    public function setTurnType(int $turnType): void
    {
        switch($turnType){
            case $turnType === Push::ID:
                $this->turn = new Push($this->board,$this->player, $this->opponent);
                break;
            case $turnType === Move::ID;
                $this->turn = new Move($this->board,$this->player, $this->opponent);
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
        $playerBoardItemCollection = new BoardItemCollection();
        $opponentBoardItemCollection = new BoardItemCollection();
        foreach($boardItems as $boardItem){
            if($boardItem->getPlayerId() === $this->player->getId()){
                $playerBoardItemCollection->add($boardItem);
            }else{
                $opponentBoardItemCollection->add($boardItem);
            }
        }
        $this->player->setBoardItems($playerBoardItemCollection);
        $this->opponent->setBoardItems($opponentBoardItemCollection);
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

    public function getPlayerActions() : string
    {
        return $this->turn->getTurn();
    }

    public function clear() : void
    {
        $this->board->clear();
    }





}