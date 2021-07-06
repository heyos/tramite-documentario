# Introduction

You are working on a multi-player board game called "Race". Players are able to move on the board (Strategy pattern), some cards from the board are used for extra moves (Chain of responsibility pattern), all players moves are logged and actual results are presented on a score board (Observer pattern). Of course, the game has an internal state like "waiting for players", "playing", "completed" (State pattern), to avoid unexpected actions.

Moving rules:

* The board contains `N + 1` fields (numbered from `0` to `N`), the starting point is `0`
* Players move by throwing the dice and moving forward the given number of fields, first to the finish is the winner
* When the dice is thrown and the result is greater than number of fields to the finish, player stays in the same place

Cards rules:

* Each field (except the first and the last one) may contain one or more cards, which may modify where the player moves
* Some cards will move the player forward (move X fields forward, at least 1)
* Some cards will move the player backwards (move X fields back, at least 1) and may be used only when the number on the dice thrown is the same on the card
* If field contains one or more cards, only the FIRST MATCHED ONE must be used (see examples below)
* Each card may be used only once, but will stay on the board until the end of the game

See example for cards setup.

# Problem Statement

To complete this task you should:

- Implement Observer pattern in `RaceGame` and `ScoringBoard` classes
- Implement Chain of Responsibility pattern in `Card` class
- Implement specified interfaces in `PlayersList` class
- Add code to places anotated with `@todo`

# Examples

## Cards

```php
$board->addCard(new AccelerateCard(4), 8);
$board->addCard(new RetreatCard(6, 3), 8);
$board->addCard(new AccelerateCard(2), 8);
```

Remarks:

* First user in field 8 will be moved to field 12 (Forward 4 fields)
* The next user in field 8 will be moved to field 5, if and only when the number on the dice thrown shows a 6; in every other case user will be moved to field 10 (Forward 2 fields)
* When all cards are used, no extra moves will be applied

# Hints

The code contains some checks for methods parameters. Think about all logical aspects of the game, e.g. is it possible to start game without players? If not, throw an exception.
