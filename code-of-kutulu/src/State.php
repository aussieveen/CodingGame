<?php


namespace CodeInGame\CodeOfKutulu;


use CodeInGame\CodeOfKutulu\Map\Map;

class State
{
    /**
     * @var Map
     */
    private $map;

    /**
     * State constructor.
     * @param Map $map
     */
    public function __construct(Map $map)
    {
        $this->map = $map;
    }

}