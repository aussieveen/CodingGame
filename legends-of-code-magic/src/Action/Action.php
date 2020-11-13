<?php


namespace CodingGame\LegendsOfCodeMagic\Action;


class Action
{
    private $cardId;

    private $actionString;

    /**
     * Action constructor.
     * @param $cardId
     * @param $actionString
     */
    public function __construct($cardId, $actionString)
    {
        $this->cardId = $cardId;
        $this->actionString = $actionString;
    }
}