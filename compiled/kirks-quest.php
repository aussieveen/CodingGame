<?php
namespace CodeInGame\LegendsOfCodeMagic {
class Debug
{
    public function __construct($item)
    {
        error_log(var_export($item, true));
    }
}
}

namespace CodingGame\KirksQuests {
class Mountain
{
    /**
     * @var int
     */
    private $height;
    /**
     * @var int
     */
    private $position;
    public function __construct(int $height, int $position)
    {
        $this->height = $height;
        $this->position = $position;
    }
    /**
     * @return int
     */
    public function getHeight() : int
    {
        return $this->height;
    }
    /**
     * @return int
     */
    public function getPosition() : int
    {
        return $this->position;
    }
}
}

namespace CodingGame\KirksQuests {
// game loop
while (TRUE) {
    $state = new State();
    $state->update();
    echo $state->target() . "\n";
    // Write an action using echo(). DON'T FORGET THE TRAILING \n
    // To debug (equivalent to var_dump): error_log(var_export($var, true));
}
}

namespace CodingGame\KirksQuests {
use CodeInGame\LegendsOfCodeMagic\Debug;
class State
{
    private $mountains = [];
    public function update()
    {
        for ($i = 0; $i < 8; $i++) {
            fscanf(STDIN, "%d", $mountainHeight);
            $this->mountains[] = new Mountain($mountainHeight, $i);
        }
    }
    public function target()
    {
        usort($this->mountains, array($this, "comparison"));
        new Debug($this->mountains);
        return $this->mountains[0]->getPosition();
    }
    public function comparison(Mountain $mountainOne, Mountain $mountainTwo)
    {
        return $mountainOne->getHeight() < $mountainTwo->getHeight();
    }
}
}

