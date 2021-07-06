<?php

declare(strict_types=1);

namespace Base;

use Prophecy\Argument;
use Race\Player\PlayersList;
use Race\RaceGame;

class RaceGameTest extends \PHPUnit\Framework\TestCase
{
    /** @var RaceGame */
    protected $game;

    /**
     *
     */
    public function setUp()
    {
        $this->game = new RaceGame(
            $this->prophesize('Race\Player\PlayersList')->reveal(),
            $this->prophesize('Race\MovingStrategy')->reveal(),
            $this->prophesize('Race\Dice')->reveal(),
            $this->prophesize('Race\Board')->reveal()
        );
    }

    /**
     *
     */
    public function testAttachObserver()
    {
        $observer = $this->prophesize('SplObserver')->reveal();

        $this->game->attach($observer);

        $this->assertContains($observer, $this->game->getObservers());
    }

    /**
     *
     */
    public function testDetachObserver()
    {
        $observer = $this->prophesize('SplObserver')->reveal();

        $this->game->attach($observer);

        $this->assertContains($observer, $this->game->getObservers());

        $this->game->detach($observer);

        $this->assertNotContains($observer, $this->game->getObservers());
    }

    /**
     * @expectedException \LogicException
     */
    public function testObserverUniqueness()
    {
        $observer = $this->prophesize('SplObserver')->reveal();

        $this->game->attach($observer);
        $this->game->attach($observer);

        $this->fail('Exception should be thrown');
    }

    /**
     * @expectedException \LogicException
     */
    public function testDetachNonExistingObserver()
    {
        $observer = $this->prophesize('SplObserver')->reveal();

        $this->game->detach($observer);

        $this->fail('Exception should be thrown');
    }

    /**
     *
     */
    public function testNotifyObservers()
    {
        $observer1 = $this->prophesize('SplObserver');
        $observer2 = $this->prophesize('SplObserver');

        $observer1->update(Argument::type('SplSubject'))->shouldBeCalled();
        $observer2->update(Argument::type('SplSubject'))->shouldBeCalled();

        $this->game->attach($observer1->reveal());
        $this->game->attach($observer2->reveal());

        $this->game->notify();
    }

    /**
     * @expectedException \Exception
     */
    public function testStartGameWithoutPlayers()
    {
        $game = new RaceGame(
            new PlayersList(),
            $this->prophesize('Race\MovingStrategy')->reveal(),
            $this->prophesize('Race\Dice')->reveal(),
            $this->prophesize('Race\Board')->reveal()
        );

        $game->startGame();

        $this->fail('Exception should be thrown');
    }
}
