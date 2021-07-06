<?php

declare(strict_types=1);

namespace Race;

abstract class Card
{
    /**
     * @var Card
     */
    private $next = null;

    /**
     * @var bool
     */
    private $processed = false;

    /**
     * @param Card $card
     * @return void
     */
    final public function append(Card $card): void
    {
        if (is_null($this->next)) {
            $this->next = $card;
        } else {
            $this->next->append($card);
        }
    }

    /**
     * @param int $diceThrowResult
     * @return int|false
     */
    final public function handle(int $diceThrowResult)
    {
        /**
         * @todo: implement it with Chain of Responsibility pattern
         *
         * Run process($diceThrowResult) method against all stacked cards to find the first matched one.
         * Return number of fields to move and mark card as processed after use or false when all cards
         * have been used.
         *
         * Cards may return 0 fields to move, when:
         * - they are used already
         * - some conditions are not satisfied, e.g. dice throw result is different than number on RetreatCard
         */
        return false;
    }

    /**
     * @return Card|null
     */
    final public function getNext(): ?Card
    {
        return $this->next;
    }

    /**
     * @param int $diceThrowResult
     * @return int
     */
    abstract protected function process(int $diceThrowResult): int;
}
