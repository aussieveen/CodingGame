<?php


namespace CodeInGame\CodeOfKutulu;


use CodeInGame\CodeOfKutulu\Map\Map;
use CodingGame\CodeOfKutulu\Entities\Effects\Light;
use CodingGame\CodeOfKutulu\Entities\Effects\Plan;
use CodingGame\CodeOfKutulu\Entities\Explorer;
use CodingGame\CodeOfKutulu\Entities\Positionable;
use CodingGame\CodeOfKutulu\Entities\Wanderer;
use CodingGame\CodeOfKutulu\Coordinates;

class Game
{

    use Geometry;

    /**
     * @var int
     */
    private $sanityLoss;
    /**
     * @var int
     */
    private $sanityLossGroup;
    /**
     * @var int
     */
    private $wandererSpawnTime;
    /**
     * @var int
     */
    private $wandererLIfeTime;

    /**
     * @var Explorer
     */
    private $player;

    /**
     * @var array
     */
    private $explorers;
    /**
     * @var array
     */
    private $wanderers;
    /**
     * @var Map
     */
    private $map;
    /**
     * @var array
     */
    private $lights;
    /**
     * @var array
     */
    private $plans;

    /**
     * State constructor.
     * @param int $sanityLoss
     * @param int $sanityLossGroup
     * @param int $wandererSpawnTime
     * @param int $wandererLIfeTime
     * @param Map $map
     */
    public function __construct(int $sanityLoss, int $sanityLossGroup, int $wandererSpawnTime, int $wandererLIfeTime, Map $map)
    {
        $this->sanityLoss = $sanityLoss;
        $this->sanityLossGroup = $sanityLossGroup;
        $this->wandererSpawnTime = $wandererSpawnTime;
        $this->wandererLIfeTime = $wandererLIfeTime;
        $this->map = $map;
    }

    public function clearState(){
        $this->explorers = [];
        $this->wanderers = [];
        $this->lights = [];
        $this->plans = [];
    }

    public function addEntity($entityType, $id, $x, $y, $param0, $param1, $param2)
    {
            switch ($entityType) {
                case "EXPLORER":
                    $this->explorers[] = new Explorer($id, $x, $y, $param0, $param1, $param2);
                    break;
                case "WANDERER":
                    $this->wanderers[] = new Wanderer($id, $x, $y, $param0, $param1, $param2);
                    break;
                case "EFFECT_LIGHT":
                    $this->lights[] = new Light($id, $x, $y, $param0, $param1);
                    break;
                case "EFFECT_PLAN":
                    $this->plans[] = new Plan($id, $x, $y, $param0, $param1);
                    break;
            }
    }

    public function addPlayer($id, $x, $y, $param0, $param1, $param2){
        $this->player = new Explorer($id, $x, $y, $param0, $param1, $param2);
    }

    public function makeMove()
    {

        //move away from wanders
        $shortestWandererDistance = 10000;
        if (!empty($this->wanderers)) {
            foreach ($this->wanderers as $wanderer) {

                $distance = $this->manhattanDistance($this->player->getCoordinates(), $wanderer->getCoordinates());

                if ($distance < $shortestWandererDistance) {
                    $shortestWandererDistance = $distance;
                    $closestWanderer = $wanderer;
                }
            }
            if ($shortestWandererDistance <= 2) {
                $awayFromCoordinates = $this->moveEntityAwayFromEntity($this->player, $closestWanderer);
                return $this->moveCommand($awayFromCoordinates);
            }
        }

        //move towards explorer
        if (!empty($this->explorers)) {
            $shortestExplorerDistance = 10000;
            foreach ($this->explorers as $explorer) {
                $distance = $this->manhattanDistance($this->player->getCoordinates(), $explorer->getCoordinates());
                if ($distance <= 2){
                    return "WAIT";
                }
                if ($distance < $shortestExplorerDistance) {
                    $shortestExplorerDistance = $distance;
                    $closestExplorer = $explorer;
                }
            }
            if (isset($closestExplorer)) {
                return $this->moveCommand($closestExplorer->getCoordinates());
            }
        }

        return "WAIT";

    }

    private function moveEntityAwayFromEntity(Positionable $entity, Positionable $secondEntity): Coordinates
    {
        $currentDistance = $this->manhattanDistance($entity->getCoordinates(), $secondEntity->getCoordinates());
        $moveOptions = [
            new Coordinates($entity->getX() + 1,$entity->getY()),
            new Coordinates($entity->getX() - 1,$entity->getY()),
            new Coordinates($entity->getX(),$entity->getY() + 1),
            new Coordinates($entity->getX(),$entity->getY() - 1)
        ];
        foreach($moveOptions as $moveOption){
            if ($moveOption->getX() == $secondEntity->getX() && $moveOption->getY() == $secondEntity->getY()){
                continue;
            }
            if ($this->map->isWall($moveOption)){
                continue;
            }
            if ($currentDistance >= $this->manhattanDistance($moveOption, $secondEntity->getCoordinates())){
                continue;
            }
            return $moveOption;
        }
        return ($entity->getCoordinates());
    }

    private function moveCommand(Coordinates $coordinates)
    {
        return "MOVE {$coordinates->getX()} {$coordinates->getY()}";
    }

}