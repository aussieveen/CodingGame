<?php

namespace CodingGame\CodeVsZombies;

$state = new State();
// game loop
while (TRUE) {
    $state->clearState();
    $state->update();
    echo $state->response() . "\n";
}
