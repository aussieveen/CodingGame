<?php

namespace CodingGame\LegendsOfCodeMagic\Card;

use CodingGame\LegendsOfCodeMagic\Debug;

class CardEvaluator
{
    /**
     * @var Abilities
     */
    private $abilityReader;

    public function __construct()
    {
        $this->abilityReader = new Abilities();
    }

    public function getScore(Card $card): float{
        $statPoints = $this->getStatPoints($card);
        $abilityPoints = $this->getAbilityPoints($card);
        $ownerHealthChange = $card->getOwnerHealthChange() > 0 ? $card->getOwnerHealthChange() / 2 : 0;
        $opponentHealthChange = $card->getOpponentHealthChange() < 0 ? -$card->getOpponentHealthChange() / 2 : 0;
        $cardDraw = $card->getDraw();
        $sum = $statPoints + $abilityPoints + $ownerHealthChange + $opponentHealthChange + $cardDraw;
        $score = $card->getCost() === 0 ? $sum++ : $sum / $card->getCost();

        new Debug([
            'attack' => $card->getAttack(),
            'health' => $card->getHealth(),
            'abilities' => $card->getAbilities(),
            'stats' => $statPoints,
            'abilityPoints' => $abilityPoints,
            'ownerHC' => $ownerHealthChange,
            'oppoHC' => $opponentHealthChange,
            'draw' => $cardDraw,
            'sum' => $sum,
            'cost' => $card->getCost(),
            'score' => $score]
        );
        return $score;
    }

    /**
     * @param Card $card
     * @return float
     *
     * According to game -
     * Charge worth 0.5 mana
     * Guard worth 0.5 mana
     * Breakthrough worth 1 mana
     */
    private function getAbilityPoints(Card $card): float
    {
        $points = 0;
        $abilities = $this->abilityReader->readCardAbilities($card);

        foreach($abilities as $ability){
            switch($ability){
                case ($ability === Abilities::BREAKTHROUGH):
                    $points++;
                    break;
                case ($ability === Abilities::CHARGE):
                case ($ability === Abilities::GUARD):
                    $points += 0.5;
                    break;
            }
        }

        return $points;
    }

    /**
     * @param Card $card
     * @return float
     *
     * Current assumption that 1 heath/attack = 0.5 mana
     */
    private function getStatPoints(Card $card): float
    {
        return ($card->getAttack() + $card->getHealth()) / 2;
    }
}