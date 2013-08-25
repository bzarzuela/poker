<?php 

include __DIR__ . '/../classes/Deck.class.php';

class DeckTest extends PHPUnit_Framework_TestCase
{
  public function testValueMap()
  {
    $deck = new Deck;
    
    $this->assertEquals(0, $deck->getValue('C2'));
    $this->assertEquals(51, $deck->getValue('DA'));
  }
}