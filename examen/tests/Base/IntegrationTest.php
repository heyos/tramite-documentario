<?php

declare(strict_types=1);

namespace Base;

use Race\Board;
use Race\Card\AccelerateCard;
use Race\Dice\FakeDice;
use Race\GameLogger;
use Race\MovingStrategy\TurtleStrategy;
use Race\Player\Player;
use Race\Player\PlayersList;
use Race\RaceGame;
use Race\ScoringBoard;

class IntegrationTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testGame()
    {
        $logger = $this->prophesize('Psr\Log\LoggerInterface')->reveal();

        $board = new Board(3);
        $scoringBoard = new ScoringBoard();

        $board->addCard(new AccelerateCard(), 1);

        $game = new RaceGame(
            new PlayersList(),
            new TurtleStrategy(),
            new FakeDice(2, 2),
            $board
        );

        $game->attach(new GameLogger($logger));
        $game->attach($scoringBoard);

        $this->assertInstanceOf('Race\State\WaitingForPlayersState', $game->getState());

        $game->joinPlayer(new Player('player B'));
        $game->joinPlayer(new Player('player A'));

        $game->startGame();

        $this->assertInstanceOf('Race\State\PlayingState', $game->getState());

        $game->playTurn();
        $game->playTurn();
        $game->playTurn();

        $this->assertInstanceOf('Race\State\CompletedState', $game->getState());
        $this->assertEquals(['player B' => 3], $scoringBoard->getTopPlayers(1));
    }
}
