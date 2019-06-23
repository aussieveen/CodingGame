<?php

namespace CodingGame\MarsLander;

use CodingGame\MarsLander\Lander\Lander;

$lander = new Lander();
// game loop
while (TRUE)
{
    fscanf(STDIN, "%d %d %d %d %d %d %d",
        $x,
        $y,
        $hSpeed, // the horizontal speed (in m/s), can be negative.
        $vSpeed, // the vertical speed (in m/s), can be negative.
        $fuel, // the quantity of remaining fuel in liters.
        $rotate, // the rotation angle in degrees (-90 to 90).
        $power // the thrust power (0 to 4).
    );

    $lander->updatePosition($x,$y,$hSpeed,$vSpeed,$fuel,$rotate,$power);
    $trajectory = $lander->getNewTrajectory();
    echo implode(" ", $trajectory ) . "\n";
}
?>