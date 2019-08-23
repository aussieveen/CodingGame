<?php

namespace CodeInGame\GhostInTheCell;

class Debug
{
    public static function debug($item)
    {
        error_log(var_export($item, true));
    }
}
