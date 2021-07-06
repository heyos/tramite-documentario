<?php

declare(strict_types=1);

namespace Race\Card;

use Race\Card;

class RetreatCard extends Card
{
    /**
     * @var int
     */
    private $thrownResult;

    /**
     * @var int
     */
    private $retreatSteps;

    /**
     * @param int $thrownResult
     * @param int $retreatSteps
     * @throws \InvalidArgumentException
     */
    public function __construct(int $thrownResult, int $retreatSteps)
    {
        if ($thrownResult <= 0) {
            throw new \InvalidArgumentException();
        }

        if ($retreatSteps <= 0) {
            throw new \InvalidArgumentException();
        }

        $this->thrownResult = $thrownResult;
        $this->retreatSteps = $retreatSteps;
    }

    /**
     * @param int $diceThrowResult
     * @return int
     */
    public function process($diceThrowResult): int
    {
        return $diceThrowResult == $this->thrownResult ? -$this->retreatSteps : 0;
    }
}
