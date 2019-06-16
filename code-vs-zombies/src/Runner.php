<?php

namespace CodingGame\CodeVsZombies;

use CodingGame\CodeVsZombies\State;

$state = new State();

// game loop
while (TRUE)
{
    $state->clearState();
    $state->update();
    echo $state->response() . "\n";
}
