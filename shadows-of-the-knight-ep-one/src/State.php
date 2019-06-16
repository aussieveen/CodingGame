<?php


namespace CodeInGame\LegendsOfCodeMagic;


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

        fscanf(STDIN, "%d %d",
            $buildingWidth, // width of the building.
            $buildingHeight // height of the building.
        );
        $building = new Building($buildingWidth, $buildingHeight);
        fscanf(STDIN, "%d",
            $this->turnsUntilDetonation // maximum number of turns before game over.
        );
        fscanf(STDIN, "%d %d",
            $batmanX,
            $batmanY
        );
        $this->batman = new Batman($building, $batmanX, $batmanY);
    }

    public function update()
    {
        while (TRUE)
        {
            fscanf(STDIN, "%s",
                $bombDir // the direction of the bombs from batman's current location (U, UR, R, DR, D, DL, L or UL)
            );

            $batmanMovement = $this->movementDictionary->translate($bombDir);
            new Debug($batmanMovement);
            $this->batman->move($batmanMovement[0], $batmanMovement[1]);

            // the location of the next window Batman should jump to.
            echo($this->batman->getPosX() . " " . $this->batman->getPosY() . "\n");
        }
    }
}