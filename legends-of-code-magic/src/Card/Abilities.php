<?php


namespace CodingGame\LegendsOfCodeMagic\Card;


class Abilities
{
    public const BREAKTHROUGH = 'B';
    public const CHARGE = 'C';
    public const GUARD = 'G';

    const DICTIONARY = [
        self::BREAKTHROUGH,
        self::CHARGE,
        self::GUARD
    ];

    public function readCardAbilities(Card $card): array
    {
        $abilities = [];

        foreach (str_split($card->getAbilities()) as $ability) {
            if (in_array($ability, self::DICTIONARY, true)) {
                $abilities[] = $ability;
            }
        }

        return $abilities;
    }

    public function hasCharge(Card $card): bool
    {
        return strstr($card->getAbilities(), self::CHARGE) >= 0;
    }

    public function hasGuard(Card $card): bool
    {
        return strstr($card->getAbilities(), self::GUARD) >= 0;
    }

    public function hasBreakthrough(Card $card): bool
    {
        return strstr($card->getAbilities(), self::BREAKTHROUGH) >= 0;
    }
}