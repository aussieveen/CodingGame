<?php


namespace CodingGame\XmasRush;


use CodingGame\XmasRush\Board\Board;
use CodingGame\XmasRush\Board\Path;
use CodingGame\XmasRush\Board\PathCollection;
use CodingGame\XmasRush\Interfaces\Positionable;
use CodingGame\XmasRush\Item\BoardItem;
use CodingGame\XmasRush\Item\BoardItemCollection;
use CodingGame\XmasRush\Item\Item;
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
     * @var array
     */
    private $pathCollection;


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
        $this->boardItemCollection = new BoardItemCollection();
        $this->questItemCollection = new QuestItemCollection();
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

    public function getBoardItemCollection() : BoardItemCollection
    {
        return $this->boardItemCollection;
    }

    public function getQuestItemCollection() : QuestItemCollection
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

        //MOVE REVEALLED QUEST ITEM FROM BOARD INTO POSSESSION
        foreach($this->getPlayerQuestItems() as $questItem)
        {
            foreach($this->getPlayerBoardItems() as $boardItem){
                if ($boardItem->getName() !== $questItem->getName()){
                    continue;
                }

                if ($this->positionableOnBoardEdge($boardItem)){
                    return $this->pushPositionableOffEdge($boardItem);
                }
            }
        }

        //MOVE PLAYER ONTO COLLECTABLE ITEM PATH


        //MOVE PLAYER COLLECTABLE ITEM INTO PATH

        //MOVE PLAYER QUEST REVEALLED BOARD ITEM TOWARDS EDGE

        return "PUSH 1 DOWN\n";
    }

    private function getMoveTurn() : string
    {
        $playerPoint = $this->player->getPoint();
        //IF POSSESS ITEM, GET TO EDGE
        if ($this->playerHasQuestItemInPossession()){
            if ($playerPoint->getX() === 0 || $playerPoint->getY() === 0){
                return "PASS\n";
            }
        }
        $this->pathCollection = new PathCollection($this->board);
        $path = $this->pathCollection->getPathForPoint($playerPoint);

        $questItemsOnBoard = $this->getPlayerQuestItemsOnBoard();
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

    private function getPlayerQuestItems():QuestItemCollection
    {
        $playerQuestItems = new QuestItemCollection();
        foreach($this->questItemCollection as $questItem){
            if (!$this->isOpponentItem($questItem)){
                $playerQuestItems->add($questItem);
            }
        }
        return $playerQuestItems;
    }

    private function getPlayerBoardItems():BoardItemCollection
    {
        $playerBoardItems = new BoardItemCollection();
        foreach($this->getBoardItemCollection() as $boardItem)
        {
            if ($this->isOpponentItem($boardItem)){
                continue;
            }

            $playerBoardItems->add($boardItem);
        }

        return $playerBoardItems;
    }

    private function getPlayerQuestItemsOnBoard():BoardItemCollection
    {
        $playerQuestItems = $this->getPlayerQuestItems();
        $playerBoardItems = $this->getPlayerBoardItems();
        $questOnBoardItems = new BoardItemCollection();
        foreach($playerQuestItems as $playerQuestItem){
            foreach($playerBoardItems as $playerBoardItem){
                if ($playerBoardItem->getName() === $playerQuestItem->getName()){
                    $questOnBoardItems->add($playerBoardItem);
                    continue 2;
                }
            }
        }
        return $questOnBoardItems;
    }

    private function isOpponentItem(Item $item): bool
    {
        return $item->getPlayerId() === self::OPPONENT_ID;
    }

    private function playerHasQuestItemInPossession(): bool
    {
        foreach ($this->boardItemCollection as $boardItem) {
            if ($boardItem->onPlayerTile() && $boardItem->getPlayerId() === self::PLAYER_ID) {
                return true;
            }
        }
        return false;
    }

    private function positionableOnBoardEdge(Positionable $object){
        $point = $object->getPoint();
        return in_array($point->getX(), [0,6], true) || in_array($point->getY(), [0,6], true);
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

    private function position(Positionable $object): int {
        $point = $object->getPoint();
        $x = $point->getX();
        $y = $point->getY();
        return min(6 - $x, $y - 6, $x, $y);
    }

    private function getMovesToGetPositionableCloserToEdge(Positionable $object):array
    {
        $point = $object->getPoint();
        $x = $point->getX();
        $y = $point->getY();
        $moves = [];
        foreach([
                    [6 - $x, 'RIGHT', $x],
                    [$x, 'LEFT', $x],
                    [6 - $y, 'DOWN', $y],
                    [$y, 'UP', $y]
                ] as $moveOptions) {
            $moves[$moveOptions[0][] = sprintf(self::PUSH_STRING_FORMAT, $moveOptions[2], $moveOptions[1])];
        }
        return $moves;
    }


}