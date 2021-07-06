<?php

declare(strict_types=1);

namespace Race;

interface Dice
{
    /**
     * @return int
     */
    public function getSides(): int;

    /**
     * @return int
     */
    public function random(): int;
}
