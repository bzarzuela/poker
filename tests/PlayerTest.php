<?php 

include_once __DIR__ . '/../classes/Deck.class.php';
include_once __DIR__ . '/../classes/Card.class.php';
include_once __DIR__ . '/../classes/Game.class.php';
include_once __DIR__ . '/../classes/Logger.class.php';
include_once __DIR__ . '/../classes/Player.class.php';

class PlayerTest extends PHPUnit_Framework_TestCase
{
  public function testWinner()
  {
    $player = new Player;
    $player->setCards([
      new Card('D1'),
      new Card('D2'),
    ]);
    
    $community = [
      new Card('D3'),
      new Card('D4'),
      new Card('D5'),
      new Card('C4'),
      new Card('S4'),
    ];
    
    $this->assertEquals(Hand::STRAIGHT_FLUSH, $player->peekAtCards($community));
  }
}