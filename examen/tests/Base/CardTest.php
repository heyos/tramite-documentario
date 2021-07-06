<?php

declare(strict_types=1);

namespace Base;

use Prophecy\Argument;

class CardTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testHandleSingleCard()
    {
        $prophecy = $this->prophesize('Race\Card');
        $diceThrowResult = 1;

        $prophecy->process(Argument::type('integer'))->willReturn($diceThrowResult);

        $card = $prophecy->reveal();

        $this->assertEquals($diceThrowResult, $card->handle($diceThrowResult));
        $this->assertEquals(false, $card->handle($diceThrowResult));
    }

    /**
     *
     */
    public function testHandleMultipleCards()
    {
        $prophecy1 = $this->prophesize('Race\Card');
        $prophecy2 = $this->prophesize('Race\Card');
        $diceThrowResult = 1;

        $prophecy1->process(Argument::type('integer'))->willReturn($diceThrowResult);
        $prophecy2->process(Argument::type('integer'))->willReturn($diceThrowResult);

        $card1 = $prophecy1->reveal();
        $card2 = $prophecy2->reveal();

        $card1->append($card2);

        $this->assertEquals($diceThrowResult, $card1->handle($diceThrowResult));
        $this->assertEquals($diceThrowResult, $card1->handle($diceThrowResult));
        $this->assertEquals(false, $card1->handle($diceThrowResult));
    }

    /**
     *
     */
    public function testStackCards()
    {
        $prophecy1 = $this->prophesize('Race\Card');
        $prophecy2 = $this->prophesize('Race\Card');

        $card1 = $prophecy1->reveal();
        $card2 = $prophecy2->reveal();

        $card1->append($card2);

        $this->assertSame($card2, $card1->getNext());
    }
}
