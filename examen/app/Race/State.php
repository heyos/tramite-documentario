<?php

declare(strict_types=1);

namespace Race;

use Race\Player\Player;

interface State
{
    /**
     * @param RaceGame $game
     * @return void
     */
    public function setGame(RaceGame $game): void;

    /**
     * @param Player $player
     * @return void
     */
    public function joinPlayer(Player $player): void;

    /**
     * @return void
     */
    public function startGame(): void;

    /**
     * @return void
     */
    public function playTurn(): void;
}
