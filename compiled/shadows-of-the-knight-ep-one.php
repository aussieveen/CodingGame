<?php
namespace CodeInGame\LegendsOfCodeMagic {
class Batman
{
    /**
     * @var int
     */
    private $posX;
    /**
     * @var int
     */
    private $posY;
    /**
     * @var Building
     */
    private $building;
    /**
     * Batman constructor.
     * @param Building $building
     * @param int $posX
     * @param int $posY
     */
    public function __construct(Building $building, int $posX, int $posY)
    {
        $this->posX = $posX;
        $this->posY = $posY;
        $this->building = $building;
    }
    public function move(int $horizontal, int $vertical)
    {
        $this->building->updateWidthRange($this->posX, $horizontal);
        $this->building->updateHeightRange($this->posY, $vertical);
        $this->posX = $this->building->getMiddleOfWidthRange();
        $this->posY = $this->building->getMiddleOfHeightRange();
    }
    /**
     * @return int
     */
    public function getPosX() : int
    {
        return $this->posX;
    }
    /**
     * @return int
     */
    public function getPosY() : int
    {
        return $this->posY;
    }
}
}

namespace CodeInGame\LegendsOfCodeMagic {
class Building
{
    private $widthRange;
    private $heightRange;
    /**
     * Building constructor.
     * @param int $width
     * @param int $height
     */
    public function __construct(int $width, int $height)
    {
        $this->widthRange = range(0, $width - 1);
        $this->heightRange = range(0, $height - 1);
    }
    /**
     * @return array
     */
    public function getWidthRange() : array
    {
        return $this->widthRange;
    }
    /**
     * @return array
     */
    public function getHeightRange() : array
    {
        return $this->heightRange;
    }
    public function updateWidthRange(int $removeFromIndex, int $upperOrLower) : void
    {
        $this->widthRange = $this->updateRange($this->widthRange, $removeFromIndex, $upperOrLower);
    }
    public function updateHeightRange(int $removeFromIndex, int $upperOrLower) : void
    {
        $this->heightRange = $this->updateRange($this->heightRange, $removeFromIndex, $upperOrLower);
    }
    public function getMiddleOfWidthRange()
    {
        return $this->widthRange[(int) floor(0 + (count($this->widthRange) - 0) / 2)];
    }
    public function getMiddleOfHeightRange()
    {
        return $this->heightRange[(int) floor(0 + (count($this->heightRange) - 0) / 2)];
    }
    private function updateRange(array $range, int $removeFromIndex, int $upperOrLower) : array
    {
        if ($key = array_search($removeFromIndex, $range)) {
            if ($upperOrLower > 0) {
                $range = array_slice($range, $key + 1);
            } elseif ($upperOrLower < 0) {
                $range = array_slice($range, 0, $key);
            }
        }
        return $range;
    }
}
}

namespace CodeInGame\LegendsOfCodeMagic {
class Debug
{
    public function __construct($item)
    {
        error_log(var_export($item, true));
    }
}
}

namespace CodeInGame\LegendsOfCodeMagic {
class MovementDictionary
{
    private $movement = ['U' => [0, -1], 'UR' => [1, -1], 'R' => [1, 0], 'DR' => [1, 1], 'D' => [0, 1], 'DL' => [-1, 1], 'L' => [-1, 0], 'UL' => [-1, -1]];
    public function translate(string $directionalMovement) : array
    {
        return $this->movement[$directionalMovement];
    }
}
}

namespace CodingGame\ShadowsOfTheKnight {
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/
use CodeInGame\LegendsOfCodeMagic\MovementDictionary;
use CodeInGame\LegendsOfCodeMagic\State;
$state = new State(new MovementDictionary());
$state->update();
?>
<?php 
}

namespace CodeInGame\LegendsOfCodeMagic {
class State
{
    /**
     * @var int
     */
    private $turnsUntilDetonation;
    private $batman;
    private $movementDictionary;
    /**
     * State constructor.
     * @param MovementDictionary $movementDictionary
     * @internal param Building $building
     */
    public function __construct(MovementDictionary $movementDictionary)
    {
        $this->movementDictionary = $movementDictionary;
        fscanf(
            STDIN,
            "%d %d",
            $buildingWidth,
            // width of the building.
            $buildingHeight
        );
        $building = new Building($buildingWidth, $buildingHeight);
        fscanf(STDIN, "%d", $this->turnsUntilDetonation);
        fscanf(STDIN, "%d %d", $batmanX, $batmanY);
        $this->batman = new Batman($building, $batmanX, $batmanY);
    }
    public function update()
    {
        while (TRUE) {
            fscanf(STDIN, "%s", $bombDir);
            $batmanMovement = $this->movementDictionary->translate($bombDir);
            new Debug($batmanMovement);
            $this->batman->move($batmanMovement[0], $batmanMovement[1]);
            // the location of the next window Batman should jump to.
            echo $this->batman->getPosX() . " " . $this->batman->getPosY() . "\n";
        }
    }
}
}

