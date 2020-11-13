<?php

namespace CodingGame\LegendsOfCodeMagic\Action;

use CodingGame\LegendsOfCodeMagic\Card\CardCollection;
use CodingGame\LegendsOfCodeMagic\Player\Opponent;
use CodingGame\LegendsOfCodeMagic\Player\Player;

class BattleAction
{
    /**
     * @var CardCollection
     */
    private $board;
    /**
     * @var CardCollection
     */
    private $deck;
    /**
     * @var Player
     */
    private $player;
    /**
     * @var Opponent
     */
    private $opponent;

    /**
     * DraftAction constructor.
     */
    public function __construct(CardCollection $board, CardCollection $deck, Player $player, Opponent $opponent)
    {
        $this->board = $board;
        $this->deck = $deck;
        $this->player = $player;
        $this->opponent = $opponent;
    }

    public function get():array
    {
        $actions = array_merge($this->getSummons(), $this->getAttacks());
        return empty($actions) ? ["PASS"] : $actions;
    }

    private function getSummons(): array
    {
        $summons = [];
        $inHand = $this->board->listByLocation(0);
        $mana = $this->player->getMana();
        foreach($inHand as $card){
            if ($card->getCost() <= $mana){
                $summons[] = 'SUMMON ' . $card->getInstanceId();
            }
            if ($mana === 0){
                return $summons;
            }
        }
        return $summons;
    }

    private function getAttacks(): array
    {
        $onPlayerBoard = $this->board->listByLocation(1);
        $onOpponentBoard = $this->board->listByLocation(-1);
        $attacks = [];
        if (!empty($onPlayerBoard)) {
            foreach ($onPlayerBoard as $card) {
                $attacks[] = 'ATTACK ' . $card->getInstanceId() . ' -1';
            }
        }
        return $attacks;
    }
}