<?php

namespace CodingGame\LegendsOfCodeMagic;

use CodingGame\LegendsOfCodeMagic\Action\Action;

class StateReader
{
    /**
     * @var Game
     */
    private $game;

    /**
     * StateReader constructor.
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function updateState():void
    {
        $this->updatePlayer();
        $this->updateOpponent();
        $this->updateBoard();
    }

    private function updatePlayer()
    {
        fscanf(STDIN, "%d %d %d %d %d", $health, $mana, $deckCount, $rune, $draw);
        $this->game->getPlayer()->updateState($health, $mana, $deckCount, $rune, $draw);
    }

    private function updateOpponent()
    {
        fscanf(STDIN, "%d %d %d %d %d", $health, $mana, $deckCount, $rune, $draw);
        fscanf(STDIN, "%d %d", $hand, $actionCount);

        $opponent = $this->game->getOpponent();

        $opponent->updateState($health,$mana,$deckCount,$rune,$draw,$hand);

        for ($i = 0; $i < $actionCount; $i++)
        {
            [$cardNumber, $action] = explode(' ', stream_get_line(STDIN, 20 + 1, "\n"));
            $opponent->addAction(new Action($cardNumber, $action));
        }
    }

    private function updateBoard()
    {
        fscanf(STDIN, "%d", $cardCount);
        for ($i = 0; $i < $cardCount; $i++)
        {
            fscanf(STDIN, "%d %d %d %d %d %d %d %s %d %d %d", $cardNumber, $instanceId, $location, $cardType, $cost, $attack, $defense, $abilities, $myHealthChange, $opponentHealthChange, $cardDraw);

            if($instanceId === -1){
                $instanceId = $i - 3;
            }

            $this->game->addCard($cardNumber, $instanceId, $location);
        }
    }


}