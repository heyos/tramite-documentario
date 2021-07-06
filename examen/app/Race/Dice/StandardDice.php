<?php

declare(strict_types=1);

namespace Race\Dice;

use Race\Dice;

class StandardDice implements Dice
{
    /**
     * @var int
     */
    private $sides;

    /**
     * @param int $sides
     * @throws \InvalidArgumentException
     */
    public function __construct(int $sides = 6)
    {
        if ($sides <= 1) {
            throw new \InvalidArgumentException();
        }

        $this->sides = $sides;
    }

    /**
     * @return int
     */
    public function getSides(): int
    {
        return $this->sides;
    }

    /**
     * @return int
     */
    public function random(): int
    {
        return rand(1, $this->sides);
    }
}
