<?php

namespace CodingGame\XmasRush;

$game = new Game(new Player\Player(), new Player\Player());
$stateReader = new StateReader($game);

// game loop
while (TRUE)
{
    $stateReader->updateState();

    echo $game->getPlayerActions();

    $game->clear();
}
?>