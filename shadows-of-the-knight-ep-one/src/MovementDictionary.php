<?php


namespace CodeInGame\LegendsOfCodeMagic;


class MovementDictionary
{
    private $movement = [
        'U' => [0,-1],
        'UR' => [1,-1],
        'R' => [1,0],
        'DR' => [1,1],
        'D' => [0, 1],
        'DL' => [-1, 1],
        'L' => [-1, 0],
        'UL' => [-1, -1]
    ];

    public function translate(string $directionalMovement): array
    {
        return $this->movement[$directionalMovement];
    }
}