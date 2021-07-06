<?php

declare(strict_types=1);

namespace Base;

use Race\Board;
use Race\Player\Player;
use Race\Player\PlayersList;
use Race\RaceGame;
use Race\ScoringBoard;

class ScoringBoardTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getData
     * @param array $playersData
     * @param int $topLength
     * @param array $results
     */
    public function testUpdateResults(array $playersData, int $topLength, array $results)
    {
        $scoringBoard = new ScoringBoard();

        $this->assertEmpty($scoringBoard->getTopPlayers($topLength));

        $scoringBoard->update($this->prepareGame($playersData));

        $this->assertEquals($results, $scoringBoard->getTopPlayers($topLength));
    }

    /**
     * @param array $playersData
     * @return RaceGame
     */
    protected function prepareGame(array $playersData): RaceGame
    {
        $game = new RaceGame(
            new PlayersList(),
            $this->prophesize('Race\MovingStrategy')->reveal(),
            $this->prophesize('Race\Dice')->reveal(),
            new Board(100)
        );

        foreach ($playersData as [, $player]) {
            $game->joinPlayer($player);
        }

        $game->startGame();

        foreach ($playersData as [$position, $player]) {
            $game->getBoard()->moveTo($player, $position);
        }

        return $game;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $players = [
            [5, new Player('player A')],
            [10, new Player('player B')],
            [2, new Player('player C')],
            [4, new Player('player D')],
            [1, new Player('player E')],
        ];

        return [
            // playersData, topLength, results
            [$players, 1, ['player B' => 10]],
            [$players, 2, ['player B' => 10, 'player A' => 5]],
            [$players, 2, ['player B' => 10, 'player A' => 5]],
        ];
    }
}
