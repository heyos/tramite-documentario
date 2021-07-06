<?php

declare(strict_types=1);

namespace Base;

use Race\Board;

class BoardTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getDataMoves
     * @param int $size
     * @param array $steps
     * @param int $finalPosition
     */
    public function testMovePlayer(int $size, array $steps, int $finalPosition)
    {
        $player = $this->prophesize('Race\Player\Player')->reveal();
        $board = new Board($size);

        $board->put($player);

        $this->assertEquals(0, $board->getPosition($player));

        foreach ($steps as $step) {
            $board->move($player, $step);
        }

        $this->assertEquals($finalPosition, $board->getPosition($player));
    }

    /**
     * @return array
     */
    public function getDataMoves(): array
    {
        return [
            // size, steps, finalPosition
            [6, [1, 1, 1], 3],
            [6, [1, 1, 4], 6],
            [6, [1, 1, 6], 2],
            [6, [5, 2], 5],
        ];
    }

    /**
     * @dataProvider getDataMovesTo
     * @param int $size
     * @param int $position
     * @param bool $validMove
     */
    public function testMoveToPlayer(int $size, int $position, bool $validMove)
    {
        if (!$validMove) {
            $this->expectException('Exception');
        }

        $player = $this->prophesize('Race\Player\Player')->reveal();
        $board = new Board($size);

        $board->put($player);

        $this->assertEquals(0, $board->getPosition($player));

        $board->moveTo($player, $position);

        $this->assertEquals($position, $board->getPosition($player));
    }

    /**
     * @return array
     */
    public function getDataMovesTo(): array
    {
        return [
            // size, position, validMove
            [6, 4, true],
            [6, 1, true],
            [6, -5, false],
            [6, 7, false],
        ];
    }

    /**
     * @dataProvider dataAddCardOnInvalidPosition
     * @expectedException \Exception
     * @param int $size
     * @param int $position
     */
    public function testAddCardOnInvalidPosition(int $size, int $position)
    {
        $board = new Board($size);

        $board->addCard($this->prophesize('Race\Card')->reveal(), $position);

        $this->fail('Exception should be thrown');
    }

    /**
     * @return array
     */
    public function dataAddCardOnInvalidPosition(): array
    {
        return [
            // size, position
            [3, -1],
            [3, 0],
            [3, 3],
            [3, PHP_INT_MAX],
        ];
    }

    /**
     * @dataProvider dataGetCardOutsideBoard
     * @expectedException \Exception
     * @param int $size
     * @param int $position
     */
    public function testGetCardOutsideBoard(int $size, int $position)
    {
        $board = new Board($size);

        @$board->getCard($position);

        $this->fail('Exception should be thrown');
    }

    /**
     * @return array
     */
    public function dataGetCardOutsideBoard(): array
    {
        return [
            // size, position
            [3, -1],
            [3, 4],
            [3, PHP_INT_MAX],
        ];
    }

    /**
     * @expectedException \Exception
     */
    public function testGetPositionForNonExistingPlayer()
    {
        $board = new Board(6);
        $player = $this->prophesize('Race\Player\Player')->reveal();

        @$board->getPosition($player);

        $this->fail('Exception should be thrown');
    }
}
