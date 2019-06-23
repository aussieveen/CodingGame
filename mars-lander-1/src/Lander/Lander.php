<?php


namespace CodingGame\MarsLander\Lander;


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

    public function updatePosition($x, $y, $horizontalSpeed, $verticalSpeed, $fuel,$rotate, $power){
        $this->x = $x;
        $this->y = $y;
        $this->horizontalSpeed = $horizontalSpeed;
        $this->verticalSpeed = $verticalSpeed;
        $this->fuel = $fuel;
        $this->rotate = $rotate;
        $this->power = $power;

    }

    public function getNewTrajectory():array{
        if (self::SAFE_LANDING_VELOCITY_VERTICAL > $this->verticalSpeed){
            $this->power = self::MAX_POWER;
        }else{
            $this->power = self::MIN_POWER;
        }

        $this->rotate = 0;

        return [$this->rotate,$this->power];
    }
}