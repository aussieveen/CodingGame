<?php

namespace CodingGame\LegendsOfCodeMagic;

use CodingGame\LegendsOfCodeMagic\Action\BattleAction;
use CodingGame\LegendsOfCodeMagic\Action\DraftAction;
use CodingGame\LegendsOfCodeMagic\Card\CardCollection;
use CodingGame\LegendsOfCodeMagic\Card\CardFactory;
use CodingGame\LegendsOfCodeMagic\Player\Opponent;
use CodingGame\LegendsOfCodeMagic\Player\Player;

class Game
{
    /**
     * @var Player
     */
    private $player;

    /**
     * @var Opponent
     */
    private $opponent;

    /**
     * @var CardCollection
     */
    private $board;
    /**
     * @var CardFactory
     */
    private $cardFactory;
    /**
     * @var CardCollection
     */
    private $deck;

    /**
     * Game constructor.
     * @param Player $player
     * @param Opponent $opponent
     */
    public function __construct(Player $player, Opponent $opponent)
    {
        $this->player = $player;
        $this->opponent = $opponent;
        $this->board = new CardCollection();
        $this->cardFactory = new CardFactory();
        $this->deck = new CardCollection();
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @return Opponent
     */
    public function getOpponent(): Opponent
    {
        return $this->opponent;
    }

    public function addCard(int $number, int $instanceId, int $location):void
    {
        $this->board->add($this->cardFactory->create($number, $instanceId),$location);
    }

    public function getPlayerActions(): string
    {
        $actions = $this->board->getByInstanceId(-1) ?
            (new DraftAction($this->board, $this->deck))->get() :
            (new BattleAction($this->board, $this->deck, $this->player, $this->opponent))->get();

        return implode(';', $actions) . "\n";
    }

    public function clearBoard()
    {
        $this->board->clear();
    }


}