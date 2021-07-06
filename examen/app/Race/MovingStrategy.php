<?php

declare(strict_types=1);

namespace Race;

interface MovingStrategy
{
    /**
     * @param Dice $dice
     * @return int
     */
    public function calculate(Dice $dice): int;
}
