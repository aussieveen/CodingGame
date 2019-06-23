<?php


namespace CodingGame\MarsLander\Mars;


class Mars
{

    const GRAVITY = 3.711;
    const WIDTH = 7000;
    const HEIGHT = 3000;

    private $map;

    public function draw(){
        fscanf(STDIN, "%d",
            $surfaceN // the number of points used to draw the surface of Mars.
        );
        for ($i = 0; $i < $surfaceN; $i++)
        {
            fscanf(STDIN, "%d %d",
                $landX, // X coordinate of a surface point. (0 to 6999)
                $landY // Y coordinate of a surface point. By linking all the points together in a sequential fashion, you form the surface of Mars.
            );
        }
        $this->map[$landX] = $landY;
    }

    public function findLandingSite(){

    }

}