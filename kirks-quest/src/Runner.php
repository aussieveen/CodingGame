<?php

namespace CodingGame\KirksQuests;

// game loop
while (TRUE)
{
    $state = new State();
    $state->update();
    echo $state->target() . "\n";

    // Write an action using echo(). DON'T FORGET THE TRAILING \n
    // To debug (equivalent to var_dump): error_log(var_export($var, true));
}
?>