<?php

namespace CodingGame\CodeOfKutulu\Entities\Effects;

interface Effect{
    public function getTurnsRemaining():int;
    public function getRange():int;
}