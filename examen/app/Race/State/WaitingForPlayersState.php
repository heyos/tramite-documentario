<?php

declare(strict_types=1);

namespace Race\State;

use Race\Player\Player;
use Race\RaceGame;
use Race\State;

class WaitingForPlayersState implements State
{
    /**
     * @var RaceGame
     */
    private $game;

    /**
     * @param RaceGame $game
     * @return void
     */
    public function setGame(RaceGame $game): void
    {
        $this->game = $game;
    }

    /**
     * @param Player $player
     * @return void
     */
    public function joinPlayer(Player $player): void
    {
        $this->game->getPlayers()->joinPlayer($player);
    }

    /**
     * @return void
     * @throws \LogicException
     */
    public function startGame(): void
    {
        foreach ($this->game->getPlayers() as $player) {
            $this->game->getBoard()->put($player);
        }

        $this->game->setState(new PlayingState());
    }

    /**
     * @return void
     */
    public function playTurn(): void
    {
        throw new \LogicException();
    }
}
