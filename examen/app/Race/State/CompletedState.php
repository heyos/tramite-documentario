<?php

declare(strict_types=1);

namespace Race\State;

use Race\Player\Player;
use Race\RaceGame;
use Race\State;

class CompletedState implements State
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
     * @throws \LogicException
     */
    public function joinPlayer(Player $player): void
    {
        throw new \LogicException();
    }

    /**
     * @return void
     */
    public function startGame(): void
    {
        $board = $this->game->getBoard();

        foreach ($this->game->getPlayers() as $player) {
            $board->moveTo($player, 0);
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
