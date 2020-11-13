<?php


namespace CodingGame\LegendsOfCodeMagic\Player;


class Player
{
    private $health;

    private $mana;

    private $deckCount;

    private $rune;

    private $draw;

    public function updateState(int $health, int $mana, int $deckCount, int $rune, int $draw){
        $this->health = $health;
        $this->mana = $mana;
        $this->deckCount = $deckCount;
        $this->rune = $rune;
        $this->draw = $draw;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    public function setHealth(int $health): void
    {
        $this->health = $health;
    }

    public function getMana(): int
    {
        return $this->mana;
    }

    public function setMana(int $mana): void
    {
        $this->mana = $mana;
    }

    public function getDeckCount(): int
    {
        return $this->deckCount;
    }

    public function setDeckCount(int $deckCount): void
    {
        $this->deckCount = $deckCount;
    }

    public function getRune(): int
    {
        return $this->rune;
    }

    public function setRune(int $rune): void
    {
        $this->rune = $rune;
    }

    public function getDraw(): int
    {
        return $this->draw;
    }

    public function setDraw(int $draw): void
    {
        $this->draw = $draw;
    }
}