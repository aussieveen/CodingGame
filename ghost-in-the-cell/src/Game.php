<?php


namespace CodingGame\GhostInTheCell;


use CodeInGame\GhostInTheCell\Debug;
use CodeInGame\GhostInTheCell\Entity\Bomb;
use CodeInGame\GhostInTheCell\Entity\Factory;
use CodeInGame\GhostInTheCell\Entity\Troop;

class Game
{

    private $factoryCount = 0;
    private $linkCount = 0;
    private $factories = [];

    public function initialise()
    {
        fscanf(STDIN, "%d",
            $factoryCount // the number of factories
        );

        $this->factoryCount = $factoryCount;

        fscanf(STDIN, "%d",
            $linkCount // the number of links between factories
        );

        $this->linkCount = $linkCount;

        for ($i = 0; $i < $linkCount; $i++) {
            fscanf(STDIN, "%d %d %d",
                $factory1,
                $factory2,
                $distance
            );

            $factories[$factory1][$factory2] = $distance;
            $factories[$factory2][$factory1] = $distance;
        }
        foreach ($factories as $factoryId => $links) {
            $this->factories[$factoryId] = new Factory($links);
        }

    }

    public function updateState()
    {

        $this->troops = [];

        fscanf(STDIN, "%d",
            $entityCount // the number of entities (e.g. factories and troops)
        );
        for ($i = 0; $i < $entityCount; $i++) {
            fscanf(STDIN, "%d %s %d %d %d %d %d",
                $entityId,
                $entityType,
                $arg1,
                $arg2,
                $arg3,
                $arg4,
                $arg5
            );

            switch ($entityType) {
                case 'FACTORY':
                    $this->factories[$entityId]->update($arg1, $arg2, $arg3, $arg4, $arg5);
                    break;
                case 'TROOP':
                    $this->factories[$arg3]->incomingTroop(new Troop($arg1, $arg2, $arg3, $arg4, $arg5));
                    break;
                case 'BOMB':
                    if($arg1 === 1){
                        $this->factories[$arg3]->incomingBomb(new Bomb($arg1, $arg2, $arg3, $arg4, $arg5));
                    }
            }
        }
    }

    public function makeMove() : array
    {
        $minDistance = 100;
        $orders = [];
        foreach($this->factories as $factoryId => $factory){
            if ($factory->getOwner() < 1){
                continue;
            }
            $links = $factory->getLinks();

            foreach($links as $linkedFactoryId => $distance){
                $potentialTarget = $this->factories[$linkedFactoryId];
                if ($potentialTarget->getOwner() === 1){
                    continue;
                }
                if ($minDistance < $distance ){
                    continue;
                }

                $cyborgsRequired = $potentialTarget->getCyborgs() + ($potentialTarget->getProduction() * $distance);

                if ($cyborgsRequired >= $factory->getCyborgs()){
                    continue;
                }

                $orders[] = sprintf('MOVE %d %d %d', $factoryId, $linkedFactoryId, $cyborgsRequired + 1);
                $minDistance = $distance;
            }

        }
        return $orders ?? ['WAIT'];
    }
}