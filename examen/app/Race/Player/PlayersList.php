<?php

declare(strict_types=1);

namespace Race\Player;

class PlayersList implements \Iterator, \Countable
{
    /**
     * @var Player[]
     */
    private $players = [];

    /**
     * @param Player[] $players
     * @throws \InvalidArgumentException
     */
    public function __construct($players = [])
    {
        foreach ($players as $player) {
            if (!$player instanceof Player) {
                throw new \InvalidArgumentException();
            }
        }

        $this->players = $players;
    }

    /**
     * @param Player $player
     * @return void
     * @throws \InvalidArgumentException
     */
    public function joinPlayer(Player $player): void
    {
        /**
         * @todo: implement it
         *
         * Each player must be unique
         */
    }

    /**
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @return Player|null
     */
    public function current(): ?Player
    {
        /**
         * @todo: implement it
         */
        return null;
    }

    /**
     * @return void
     */
    public function next(): void
    {
        /**
         * @todo: implement it
         */
    }

    /**
     * @return int|null
     */
    public function key(): ?int
    {
        /**
         * @todo: implement it
         */
        return null;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        /**
         * @todo: implement it
         */
        return false;
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        /**
         * @todo: implement it
         */
    }

    /**
     * @return int
     */
    public function count(): int
    {
        /**
         * @todo: implement it
         */
        return 0;
    }
}
