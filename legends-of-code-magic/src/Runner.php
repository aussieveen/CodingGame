<?php

namespace CodingGame\LegendsOfCodeMagic;

use CodingGame\LegendsOfCodeMagic\Player\Opponent;
use CodingGame\LegendsOfCodeMagic\Player\Player;

$game = new Game(new Player(), new Opponent());
$state = new StateReader($game);

while (TRUE)
{
    $state->updateState();

    echo $game->getPlayerActions();

    $game->clearBoard();
}