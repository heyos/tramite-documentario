<?php

declare(strict_types=1);

namespace Race\Dice;

class FakeDice extends StandardDice
{
    /**
     * @var int
     */
    private $result;

    /**
     * @param int $sides
     * @param int $result
     * @throws \InvalidArgumentException
     */
    public function __construct(int $sides = 6, int $result = 1)
    {
        parent::__construct($sides);


        $this->result = $result;
    }

    /**
     * @return int
     */
    public function random(): int
    {
        return $this->result;
    }
}
