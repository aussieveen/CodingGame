<?php

namespace CodingGame\MarsLander;

class Debug
{
    public function __construct($item)
    {
        error_log(var_export($item, true));
    }
}
