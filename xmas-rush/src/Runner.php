<?php

namespace CodingGame\XmasRush;

$game = new Game(new Player\Player(0), new Player\Player(1));
$stateReader = new StateReader($game);

// game loop
while (TRUE)
{
    $stateReader->updateState();
    echo $game->getPlayerAction();
    $game->clear();
}
