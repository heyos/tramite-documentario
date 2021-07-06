<?php

declare(strict_types=1);

namespace Race;

use Psr\Log\LoggerInterface;

class GameLogger implements \SplObserver
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param \SplSubject $subject
     * @return void
     */
    public function update(\SplSubject $subject): void
    {
        if ($subject instanceof RaceGame) {
            $this->logger->info('Start turn');

            foreach ($subject->getPlayers() as $player) {
                $this->logger->info(
                    sprintf(
                        'Player %s is on position %d',
                        $player->getNick(),
                        $subject->getBoard()->getPosition($player)
                    )
                );
            }

            $this->logger->info('End turn');
        }
    }
}
