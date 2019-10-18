<?php

namespace CodingGame\LegendsOfCodeMagic;

while (TRUE)
{
    for ($i = 0; $i < 2; $i++)
    {
        fscanf(STDIN, "%d %d %d %d %d",
            $playerHealth,
            $playerMana,
            $playerDeck,
            $playerRune,
            $playerDraw
        );
    }
    fscanf(STDIN, "%d %d",
        $opponentHand,
        $opponentActions
    );
    for ($i = 0; $i < $opponentActions; $i++)
    {
        $cardNumberAndAction = stream_get_line(STDIN, 20 + 1, "\n");
    }
    fscanf(STDIN, "%d",
        $cardCount
    );
    for ($i = 0; $i < $cardCount; $i++)
    {
        fscanf(STDIN, "%d %d %d %d %d %d %d %s %d %d %d",
            $cardNumber,
            $instanceId,
            $location,
            $cardType,
            $cost,
            $attack,
            $defense,
            $abilities,
            $myHealthChange,
            $opponentHealthChange,
            $cardDraw
        );
    }

    // Write an action using echo(). DON'T FORGET THE TRAILING \n
    // To debug (equivalent to var_dump): error_log(var_export($var, true));

    echo("PASS\n");
}
?>