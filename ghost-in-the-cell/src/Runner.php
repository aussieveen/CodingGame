<?php

namespace CodingGame\GhostInTheCell;

$game = new Game();

$game->initialise();

while(TRUE){
    $game->updateState();

    echo implode(";",$game->makeMove()) . "\n";
}
?>