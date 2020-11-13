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
        $opponentHealthChange = $card->getOpponentHealthChange() < 0 ? -$card->getOpponentHealthChange() : 0;
        $cardDraw = $card->getDraw();
        $sum = $statPoints + $abilityPoints + $ownerHealthChange + $opponentHealthChange + $cardDraw;
        $score = $sum;

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

    private function getAbilityPoints(Card $card): float
    {
        $points = 0;
        $abilities = $this->abilityReader->readCardAbilities($card);
        foreach($abilities as $ability){
            switch($ability){
                case ($ability === Abilities::BREAKTHROUGH):
                    $points += $card->getAttack() / $card->getHealth();
                    break;
                case ($ability === Abilities::CHARGE):
                    $points += ($card->getAttack() * 1.1) / $card->getHealth();
                    break;
                case ($ability === Abilities::GUARD):
                    $points += $card->getHealth() * 1.05;
                    break;
            }
        }
        return $points;
    }

    private function getStatPoints(Card $card): float
    {
        $manaCostPer2Points = ($card->getAttack() + $card->getHealth()) / 2;
        $healthDiff = $card->getHealth() - $card->getAttack();
        return $healthDiff <= 0 ? $manaCostPer2Points : $manaCostPer2Points - ($healthDiff/10);
    }
}