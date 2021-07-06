<?php

declare(strict_types=1);

namespace Race\MovingStrategy;

use Race\Dice;
use Race\MovingStrategy;

class StandardStrategy implements MovingStrategy
{
    /**
     * @param Dice $dice
     * @return int
     */
    public function calculate(Dice $dice): int
    {
        return $dice->random();
    }
}
