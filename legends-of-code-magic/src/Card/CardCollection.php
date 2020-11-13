<?php


namespace CodingGame\LegendsOfCodeMagic\Card;


use CodingGame\LegendsOfCodeMagic\Debug;

class CardCollection
{
    private $collection = [];

    public function add(Card $card, int $location): void
    {
        $this->collection[] = [
            'card' => $card,
            'location' => $location
        ];
    }

    public function getByInstanceId(int $instanceId): ?Card
    {
        foreach($this->collection as $card){
            if($card['card']->getInstanceId() === $instanceId){
                return $card['card'];
            }
        }
        return null;
    }

    public function listByLocation(int $location): ?array
    {
        $matches = [];
        foreach($this->collection as $card){
            if($card['location'] === $location){
                $matches[] = $card['card'];
            }
        }
        return empty($matches) ? null : $matches;
    }

    public function clear():void
    {
        $this->collection = [];
    }
}