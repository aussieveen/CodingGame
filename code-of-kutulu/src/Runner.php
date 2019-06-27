<?php

namespace CodingGame\CodeOfKutulu;

/**
 * Survive the wrath of Kutulu
 * Coded fearlessly by JohnnyYuge & nmahoude (ok we might have been a bit scared by the old god...but don't say anything)
 **/

use CodeInGame\CodeOfKutulu\Map\Map;

fscanf(STDIN, "%d",
    $width
);
fscanf(STDIN, "%d",
    $height
);

$map = new Map($width, $height);
for ($i = 0; $i < $height; $i++)
{
    $line = stream_get_line(STDIN, 25 + 1, "\n");
    $map->addMapRow($line);
}

fscanf(STDIN, "%d %d %d %d",
    $sanityLossLonely, // how much sanity you lose every turn when alone, always 3 until wood 1
    $sanityLossGroup, // how much sanity you lose every turn when near another player, always 1 until wood 1
    $wandererSpawnTime, // how many turns the wanderer take to spawn, always 3 until wood 1
    $wandererLifeTime // how many turns the wanderer is on map after spawning, always 40 until wood 1
);



// game loop
while (TRUE)
{
    fscanf(STDIN, "%d",
        $entityCount // the first given entity corresponds to your explorer
    );
    for ($i = 0; $i < $entityCount; $i++)
    {
        fscanf(STDIN, "%s %d %d %d %d %d %d",
            $entityType,
            $id,
            $x,
            $y,
            $param0,
            $param1,
            $param2
        );
    }

    // Write an action using echo(). DON'T FORGET THE TRAILING \n
    // To debug (equivalent to var_dump): error_log(var_export($var, true));

    echo("WAIT\n"); // MOVE <x> <y> | WAIT
}
?>