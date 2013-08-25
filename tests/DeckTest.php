<?php 

include_once __DIR__ . '/../classes/Deck.class.php';
include_once __DIR__ . '/../classes/Card.class.php';

class DeckTest extends PHPUnit_Framework_TestCase
{
  public function testValueMap()
  {
    $deck = new Deck;
    
    $this->assertEquals(0, $deck->getValue('C2'));
    $this->assertEquals(51, $deck->getValue('D1'));
  }
  
  public function testDraw()
  {
    $deck = new Deck;
    
    $this->assertEquals(5, count($deck->draw(5)));
    
    // Took out 5 cards so 47 must be left.
    $this->assertEquals(47, $deck->count());
  }
}