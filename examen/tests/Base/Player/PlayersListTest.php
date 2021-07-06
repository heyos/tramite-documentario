<?php

declare(strict_types=1);

namespace Base\Player;

use Race\Player\Player;
use Race\Player\PlayersList;

class PlayersListTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getData
     * @param array $players
     */
    public function testCounting(array $players)
    {
        $playersList = new PlayersList($players);

        $this->assertEquals(count($players), count($playersList));
        $this->assertInstanceOf('\Countable', $playersList);
    }

    /**
     * @dataProvider getData
     * @param array $players
     */
    public function testIteration(array $players)
    {
        $playersList = new PlayersList($players);

        $visitedCount = 0;
        foreach ($playersList as $key => $player) {
            $this->assertEquals($players[$key], $player);
            ++$visitedCount;
        }

        $this->assertEquals(count($players), $visitedCount);
        $this->assertInstanceOf('\Iterator', $playersList);
    }

    /**
     * @expectedException \LogicException
     */
    public function testPlayerUniqueness()
    {
        $playersList = new PlayersList();
        $player = new Player('Player A');

        $playersList->joinPlayer($player);
        $playersList->joinPlayer($player);

        $this->fail('Exception should be thrown');
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            [
                [],
            ],
            [
                [
                    new Player('A'),
                    new Player('B'),
                    new Player('C'),
                ],
            ]
        ];
    }
}
