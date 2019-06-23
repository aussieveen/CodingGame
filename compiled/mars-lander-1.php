<?php
namespace CodingGame\MarsLander {
class Debug
{
    public function __construct($item)
    {
        error_log(var_export($item, true));
    }
}
}

namespace CodingGame\MarsLander\Lander {
use CodingGame\MarsLander\Debug;
class Lander
{
    const SAFE_LANDING_VELOCITY_HORIZONTAL = 20;
    const SAFE_LANDING_VELOCITY_VERTICAL = -40;
    const ROTATIONAL_DEGREE = 15;
    const MIN_ROTATE = -90;
    const MAX_ROTATE = 90;
    const MIN_POWER = 0;
    const MAX_POWER = 4;
    private $x;
    private $y;
    private $horizontalSpeed;
    private $verticalSpeed = 0;
    private $fuel;
    private $rotate = 0;
    private $power = 0;
    public function updatePosition($x, $y, $horizontalSpeed, $verticalSpeed, $fuel, $rotate, $power)
    {
        $this->x = $x;
        $this->y = $y;
        $this->horizontalSpeed = $horizontalSpeed;
        $this->verticalSpeed = $verticalSpeed;
        $this->fuel = $fuel;
        $this->rotate = $rotate;
        $this->power = $power;
    }
    public function getNewTrajectory() : array
    {
        if (self::SAFE_LANDING_VELOCITY_VERTICAL > $this->verticalSpeed) {
            $this->power = self::MAX_POWER;
        } else {
            $this->power = self::MIN_POWER;
        }
        $this->rotate = 0;
        return [$this->rotate, $this->power];
    }
}
}

namespace CodingGame\MarsLander\Mars {
class Mars
{
    const GRAVITY = 3.711;
    const WIDTH = 7000;
    const HEIGHT = 3000;
    private $map;
    public function draw()
    {
        fscanf(STDIN, "%d", $surfaceN);
        for ($i = 0; $i < $surfaceN; $i++) {
            fscanf(
                STDIN,
                "%d %d",
                $landX,
                // X coordinate of a surface point. (0 to 6999)
                $landY
            );
        }
        $this->map[$landX] = $landY;
    }
    public function findLandingSite()
    {
    }
}
}

namespace CodingGame\MarsLander {
use CodingGame\MarsLander\Lander\Lander;
$lander = new Lander();
// game loop
while (TRUE) {
    fscanf(
        STDIN,
        "%d %d %d %d %d %d %d",
        $x,
        $y,
        $hSpeed,
        // the horizontal speed (in m/s), can be negative.
        $vSpeed,
        // the vertical speed (in m/s), can be negative.
        $fuel,
        // the quantity of remaining fuel in liters.
        $rotate,
        // the rotation angle in degrees (-90 to 90).
        $power
    );
    $lander->updatePosition($x, $y, $hSpeed, $vSpeed, $fuel, $rotate, $power);
    $trajectory = $lander->getNewTrajectory();
    echo implode(" ", $trajectory) . "\n";
}
}

