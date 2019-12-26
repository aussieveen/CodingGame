<?php

namespace CodingGame\XmasRush\Player;

use CodingGame\XmasRush\Board\Board;
use CodingGame\XmasRush\Board\Tile;
use CodingGame\XmasRush\Interfaces\Positionable;
use CodingGame\XmasRush\Item\BoardItem;
use CodingGame\XmasRush\Item\BoardItemCollection;
use CodingGame\XmasRush\Item\QuestItemCollection;
use CodingGame\XmasRush\Point;

class Player implements Positionable
{

    private $numberOfQuests;

    private $tile;
    /**
     * @var Point
     */
    private $point;

    /**
     * @var int
     */
    private $id;

    private $questItems;

    private $boardItems;
    /**
     * @var BoardItem
     */
    private $boardItem;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function updateState(int $numberOfQuests, int $x, int $y, Tile $tile): void
    {
        $this->numberOfQuests = $numberOfQuests;
        $this->point = new Point($x, $y);
        $this->tile = $tile;
    }

    /**
     * @return int
     */
    public function getNumberOfQuests() : int
    {
        return $this->numberOfQuests;
    }

    /**
     * @return Tile
     */
    public function getTile() : Tile
    {
        return $this->tile;
    }


    public function getPoint(): Point
    {
        return $this->point;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getQuestItems() : QuestItemCollection
    {
        return $this->questItems;
    }

    /**
     * @param mixed $questItems
     */
    public function setQuestItems(QuestItemCollection $questItems): void
    {
        $this->questItems = $questItems;
    }

    public function setBoardItem(BoardItem $boardItem){
        $this->boardItem = $boardItem;
    }

    public function getBoardItem(): ?BoardItem
    {
        return $this->boardItem;
    }
}