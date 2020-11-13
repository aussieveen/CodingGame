<?php


namespace CodingGame\LegendsOfCodeMagic\Card;


class Abilities
{
    public const BREAKTHROUGH = 0;
    public const CHARGE = 1;
    public const GUARD = 2;

    const DICTIONARY = [
        'B' => self::BREAKTHROUGH,
        'C' => self::CHARGE,
        'G' => self::GUARD
    ];

    public function readCardAbilities(Card $card): array
    {
        $abilities = [];

        $keys = array_keys(SELF::DICTIONARY);

        foreach (str_split($card->getAbilities()) as $ability) {
            if (in_array($ability, $keys)) {
                $abilities[] = self::DICTIONARY[$ability];
            }
        }

        return $abilities;
    }
}