<?php


namespace CodingGame\XmasRush;

use CodingGame\XmasRush\Board\Tile;
use CodingGame\XmasRush\Item\BoardItem;
use CodingGame\XmasRush\Item\Item;

class StateReader
{
    /**
     * @var Game
     */
    private $game;

    /**
     * StateReader constructor.
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function updateState(): void
    {
        $this->updateGameState();
        $this->updateBoardState();
        $this->updatePlayerState();
        $this->updateOpponentState();
        $this->updateBoardItemState();
        $this->updateQuestsState();
    }

    private function updateGameState(): void
    {
        fscanf(STDIN, "%d",
            $actionType
        );

        $this->game->setActionType($actionType);
    }

    private function updateBoardState(): void
    {
        for ($i = 0; $i < 7; $i++)
        {
            $inputs = explode(" ", fgets(STDIN));
            for ($j = 0; $j < 7; $j++)
            {
                $this->game->getBoard()->set($j,$i,new Tile($inputs[$j]));

            }
        }
    }

    private function updatePlayerState(): void
    {
        fscanf(STDIN, "%d %d %d %s",
            $numPlayerCards, // the total number of quests for a player (hidden and revealed)
            $playerX,
            $playerY,
            $playerTile
        );
        $this->game->getPlayer()->updateState($numPlayerCards, $playerX, $playerY, new Tile($playerTile));
    }

    private function updateOpponentState(): void
    {
        fscanf(STDIN, "%d %d %d %s",
            $numPlayerCards, // the total number of quests for a player (hidden and revealed)
            $playerX,
            $playerY,
            $playerTile
        );

        $this->game->getOpponent()->updateState($numPlayerCards, $playerX, $playerY, new Tile($playerTile));
    }

    private function updateBoardItemState(): void
    {
        fscanf(STDIN, "%d",
            $numItems // the total number of items available on board and on player tiles
        );
        $boardItems = [];
        for ($i = 0; $i < $numItems; $i++)
        {
            fscanf(STDIN, "%s %d %d %d",
                $itemName,
                $itemX,
                $itemY,
                $itemPlayerId
            );
            $boardItems[] = new BoardItem($itemName, $itemX, $itemY, $itemPlayerId);
        }
        $this->game->setBoardItems(...$boardItems);
    }

    private function updateQuestsState(): void
    {
        fscanf(STDIN, "%d",
            $numQuests // the total number of revealed quests for both players
        );
        $questItems = [];
        for ($i = 0; $i < $numQuests; $i++)
        {
            fscanf(STDIN, "%s %d",
                $questItemName,
                $questPlayerId
            );
            $questItems[] = new Item($questItemName, $questPlayerId);
        }
        $this->game->setQuestItems(...$questItems);
    }
}