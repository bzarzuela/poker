<?php 

include_once __DIR__ . '/../classes/Deck.class.php';
include_once __DIR__ . '/../classes/Card.class.php';
include_once __DIR__ . '/../classes/Game.class.php';
include_once __DIR__ . '/../classes/Logger.class.php';
include_once __DIR__ . '/../classes/Player.class.php';

include_once __DIR__ . '/MockLogger.php';

class GameTest extends PHPUnit_Framework_TestCase
{
  public function testSingleWinner()
  {
    $community = [
      new Card('D3'),
      new Card('D4'),
      new Card('D5'),
      new Card('C4'),
      new Card('S4'),
    ];
    
    $game = new Game;
    $game->setLogger(new MockLogger);
    $game->setCommunityCards($community);
    
    $player1 = new Player;
    $player1->setName('P1')->setCards([
      new Card('D1'),
      new Card('D2'),
    ]);
    
    $player2 = new Player;
    $player2->setName('P2')->setCards([
      new Card('S1'),
      new Card('S2'),
    ]);
    
    $game->addPlayer($player1);
    $game->addPlayer($player2);
    $game->play();
    
    $this->assertEquals(Hand::STRAIGHT_FLUSH, $player1->peekAtCards($community));
    $this->assertEquals(Hand::STRAIGHT, $player2->peekAtCards($community));
    $this->assertEquals($player1, $game->getWinner());
  }
  
  public function testStraightFlush()
  {
    $community = [
      new Card('D3'),
      new Card('D4'),
      new Card('D5'),
      new Card('C4'),
      new Card('S4'),
    ];
    
    $game = new Game;
    $game->setLogger(new MockLogger);
    $game->setCommunityCards($community);
    
    $player1 = new Player;
    $player1->setName('Player 1')->setCards([
      new Card('D1'),
      new Card('D2'),
    ]);
    
    $player2 = new Player;
    $player2->setName('Player 2')->setCards([
      new Card('D6'),
      new Card('D7'),
    ]);
    
    $game->addPlayer($player1);
    $game->addPlayer($player2);
    $game->play();
    
    $this->assertEquals(Hand::STRAIGHT_FLUSH, $player1->peekAtCards($community));
    $this->assertEquals(Hand::STRAIGHT_FLUSH, $player2->peekAtCards($community));
    $this->assertEquals($player1, $game->getWinner());
    
    
    $community = [
      new Card('D5'),
      new Card('D6'),
      new Card('D7'),
      new Card('C4'),
      new Card('S4'),
    ];
    
    $game = new Game;
    $game->setLogger(new MockLogger);
    $game->setCommunityCards($community);
    
    $player1->setCards([
      new Card('D2'),
      new Card('D3'),
    ]);
    
    $player2 = new Player;
    $player2->setName('Player 2')->setCards([
      new Card('D8'),
      new Card('D9'),
    ]);
    
    $game->addPlayer($player1);
    $game->addPlayer($player2);
    $game->play();
    
    $this->assertEquals($player2, $game->getWinner());
  }
}