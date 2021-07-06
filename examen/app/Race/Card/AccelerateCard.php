<?php

declare(strict_types=1);

namespace Race\Card;

use Race\Card;

class AccelerateCard extends Card
{
    /**
     * @var int
     */
    private $extraSteps;

    /**
     * @param int $extraSteps
     * @throws \InvalidArgumentException
     */
    public function __construct(int $extraSteps = 1)
    {
        if ($extraSteps <= 0) {
            throw new \InvalidArgumentException();
        }

        $this->extraSteps = $extraSteps;
    }

    /**
     * @param int $diceThrowResult
     * @return int
     */
    public function process(int $diceThrowResult): int
    {
        return $this->extraSteps;
    }
}
