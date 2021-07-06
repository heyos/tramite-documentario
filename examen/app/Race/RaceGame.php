<?php

declare(strict_types=1);

namespace Race;

use Race\Player\Player;
use Race\Player\PlayersList;
use Race\State\WaitingForPlayersState;

class RaceGame implements \SplSubject
{
    /**
     * @var \SplObserver[]
     */
    private $observers = [];

    /**
     * @var PlayersList
     */
    private $players;

    /**
     * @var MovingStrategy
     */
    private $movingStrategy;

    /**
     * @var Dice
     */
    private $dice;

    /**
     * @var Board
     */
    private $board;

    /**
     * @var State
     */
    private $state;

    /**
     * @param PlayersList $players
     * @param MovingStrategy $movingStrategy
     * @param Dice $dice
     * @param Board $board
     */
    public function __construct(PlayersList $players, MovingStrategy $movingStrategy, Dice $dice, Board $board)
    {
        $this->players = $players;
        $this->movingStrategy = $movingStrategy;
        $this->dice = $dice;
        $this->board = $board;

        $this->setState(new WaitingForPlayersState());
    }

    /**
     * @param Player $player
     * @return void
     */
    public function joinPlayer(Player $player): void
    {
        $this->state->joinPlayer($player);
    }

    /**
     * @return void
     * @throws \LogicException
     */
    public function startGame(): void
    {
        $this->state->startGame();

        $this->notify();
    }

    /**
     * @return void
     */
    public function playTurn(): void
    {
        $this->state->playTurn();

        $this->notify();
    }

    /**
     * @return int
     */
    public function throwDice(): int
    {
        return $this->movingStrategy->calculate($this->dice);
    }

    /**
     * @return Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * @return PlayersList
     */
    public function getPlayers(): PlayersList
    {
        return $this->players;
    }

    /**
     * @param State $state
     * @return void
     */
    public function setState(State $state): void
    {
        $state->setGame($this);

        $this->state = $state;
    }

    /**
     * @return State
     */
    public function getState(): State
    {
        return $this->state;
    }

    /**
     * @return \SplObserver[]
     */
    public function getObservers(): array
    {
        return $this->observers;
    }

    /**
     * @param \SplObserver $observer
     * @return void
     * @throws \InvalidArgumentException
     */
    public function attach(\SplObserver $observer): void
    {
        /**
         * @todo: implement it with Observer pattern
         *
         * Each $observer object must be unique on the observers list.
         */
    }

    /**
     * @param \SplObserver $observer
     * @return void
     * @throws \InvalidArgumentException
     */
    public function detach(\SplObserver $observer): void
    {
        /**
         * @todo: implement it with Observer pattern
         *
         * Observer must exists on the observers list.
         */
    }

    /**
     * @return void
     */
    public function notify(): void
    {
        /**
         * @todo: implement it with Observer pattern
         */
    }
}
