<?php

declare(strict_types=1);

namespace Race;

use Race\Player\Player;

class Board
{
    /**
     * @var int
     */
    private $size;

    /**
     * @var int[]
     */
    private $positions = [];

    /**
     * @var Card[]
     */
    private $cards = [];

    /**
     * @param int $size
     * @throws \InvalidArgumentException
     */
    public function __construct(int $size = 30)
    {
        if ($size <= 2) {
            throw new \InvalidArgumentException();
        }

        $this->size = $size;
    }

    /**
     * @param Card $card
     * @param int $position
     * @return void
     * @throws \InvalidArgumentException
     */
    public function addCard(Card $card, int $position): void
    {
        if (empty($this->cards[$position])) {
            $this->cards[$position] = $card;
        } else {
            $this->cards[$position]->append($card);
        }
    }

    /**
     * @param int $position
     * @return Card|null
     * @throws \InvalidArgumentException
     */
    public function getCard(int $position): ?Card
    {
        return $this->cards[$position];
    }

    /**
     * @param Player $player
     * @return void
     */
    public function put(Player $player): void
    {
        $this->positions[$this->getObjectId($player)] = 0;
    }

    /**
     * @param Player $player
     * @param int $steps
     * @return void
     */
    public function move(Player $player, int $steps): void
    {
        $this->positions[$this->getObjectId($player)] += $steps;
    }

    /**
     * @param Player $player
     * @param int $position
     * @return void
     */
    public function moveTo(Player $player, int $position): void
    {
        $this->positions[$this->getObjectId($player)] = $position;
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function completed(Player $player): bool
    {
        return $this->getPosition($player) == $this->size;
    }

    /**
     * @param Player $player
     * @return int
     * @throws \InvalidArgumentException
     */
    public function getPosition(Player $player): int
    {
        return $this->positions[$this->getObjectId($player)];
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param Player $player
     * @return string
     */
    private function getObjectId(Player $player): string
    {
        return spl_object_hash($player);
    }
}
