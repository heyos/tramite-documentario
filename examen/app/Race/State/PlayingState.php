<?php

declare(strict_types=1);

namespace Race\State;

use Race\Card;
use Race\Player\Player;
use Race\RaceGame;
use Race\State;

class PlayingState implements State
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
     * @throws \LogicException
     */
    public function startGame(): void
    {
        throw new \LogicException();
    }

    /**
     * @return void
     */
    public function playTurn(): void
    {
        $board = $this->game->getBoard();

        foreach ($this->game->getPlayers() as $player) {
            $diceThrownResult = $this->game->throwDice();

            $board->move($player, $diceThrownResult);

            $card = $board->getCard($board->getPosition($player));

            if ($card instanceof Card) {
                $board->move($player, $card->handle($diceThrownResult));
            }

            if ($board->completed($player)) {
                $this->game->setState(new CompletedState());

                break;
            }
        }
    }
}
