<?php

declare(strict_types=1);

namespace Race\Player;

class Player
{
    /**
     * @var string
     */
    private $nick;

    /**
     * @param string $nick
     * @throws \InvalidArgumentException
     */
    public function __construct(string $nick)
    {
        $this->nick = $nick;
    }

    /**
     * @return string
     */
    public function getNick(): string
    {
        return $this->nick;
    }
}
