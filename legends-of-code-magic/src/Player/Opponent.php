<?php

namespace CodingGame\LegendsOfCodeMagic\Player;

use CodingGame\LegendsOfCodeMagic\Action\Action;

class Opponent extends Player
{
    private $hand;

    private $actions;

    public function updateState(
        int $health,
        int $mana,
        int $deckCount,
        int $rune,
        int $draw,
        int $hand = 0
    ): void
    {
        $this->hand = $hand;
        parent::updateState($health, $mana, $deckCount, $rune, $draw);
    }

    public function addAction(Action $action):void
    {
        $this->actions[] = $action;
    }

}