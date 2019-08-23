<?php

namespace CodingGame\CodeVsZombies;

$game = new Game();
// game loop
while (TRUE) {
    $game->clearState();
    $game->update();
    echo $game->response() . "\n";
}
