<?php

namespace CodingGame\KirksQuests;


use CodeInGame\LegendsOfCodeMagic\Debug;

class State
{
    private $mountains = [];

    public function update(){
        for ($i = 0; $i < 8; $i++)
        {
            fscanf(STDIN, "%d", $mountainHeight);
            $this->mountains[] = new Mountain($mountainHeight, $i);
        }
    }

    public function target(){
        usort($this->mountains, array($this, "comparison"));
        new Debug($this->mountains);
        return $this->mountains[0]->getPosition();
    }

    public function comparison(Mountain $mountainOne, Mountain $mountainTwo){
        return $mountainOne->getHeight() < $mountainTwo->getHeight();
    }




}