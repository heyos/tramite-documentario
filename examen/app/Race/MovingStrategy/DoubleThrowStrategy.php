<?php

declare(strict_types=1);

namespace Race\MovingStrategy;

use Race\Dice;
use Race\MovingStrategy;

class DoubleThrowStrategy implements MovingStrategy
{
    /**
     * @param Dice $dice
     * @return int
     */
    public function calculate(Dice $dice): int
    {
        $steps = $dice->random() + $dice->random();

        return $steps <= 2 ? 0 : $steps;
    }
}
