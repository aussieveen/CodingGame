<?php

namespace CodingGame\CodeVsZombies\Characters;

interface Attacker
{
    public function getKillDistance(): int;
}