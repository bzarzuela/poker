<?php 

include_once __DIR__ . '/../classes/Hand.class.php';
include_once __DIR__ . '/../classes/Card.class.php';

class HandTest extends PHPUnit_Framework_TestCase
{
  public function testFlush()
  {
    $hand = new Hand;
    $hand->setCards([
      new Card('D1'),
      new Card('D2'),
      new Card('D3'),
      new Card('D4'),
      new Card('D5'),
      new Card('D6'),
      new Card('D7'),
    ]);
    
    $this->assertTrue($hand->isFlush());
    
    $hand->setCards([
      new Card('C1'),
      new Card('C2'),
      new Card('D3'),
      new Card('D4'),
      new Card('D5'),
      new Card('D6'),
      new Card('D7'),
    ]);
    
    $this->assertTrue($hand->isFlush());
    
    $hand->setCards([
      new Card('C1'),
      new Card('C2'),
      new Card('C3'),
      new Card('D4'),
      new Card('D5'),
      new Card('D6'),
      new Card('D7'),
    ]);
    
    $this->assertFalse($hand->isFlush());
  }
  
  public function testQuad()
  {
    $hand = new Hand;
    $hand->setCards([
      new Card('C3'),
      new Card('D3'),
      new Card('S3'),
      new Card('H3'),
      new Card('D5'),
      new Card('D6'),
      new Card('D7'),
    ]);
    
    $this->assertTrue($hand->isQuad());
    
    $hand->setCards([
      new Card('C3'),
      new Card('D3'),
      new Card('S3'),
      new Card('H4'),
      new Card('D5'),
      new Card('D6'),
      new Card('D7'),
    ]);
    
    $this->assertFalse($hand->isQuad());
  }
  
  public function testHighestHand()
  {
    $hand = new Hand;
    $highest = new Card('D1');
    $lowest = new Card('C2');
    
    $hand->setCards([
      $highest,
      new Card('H1'),
      new Card('S3'),
      new Card('H3'),
      new Card('D5'),
      new Card('D6'),
      $lowest,
    ]);
    
    $this->assertEquals($highest, $hand->getHighestCard());
    $this->assertNotEquals($lowest, $hand->getHighestCard());
    
    $highest = new Card('D1');
    $lowest = new Card('C2');
    
    $hand->setCards([
      $highest,
      new Card('D2'),
      new Card('S3'),
      new Card('H3'),
      new Card('D5'),
      new Card('D6'),
      $lowest,
    ]);
    
    $this->assertEquals($highest, $hand->getHighestCard());
    $this->assertNotEquals($lowest, $hand->getHighestCard());
  }
  
  public function testFullHouse()
  {
    $hand = new Hand;
    $hand->setCards([
      new Card('C3'),
      new Card('D3'),
      new Card('S3'),
      new Card('H7'),
      new Card('D7'),
      new Card('D8'),
      new Card('D9'),
    ]);
    
    $this->assertTrue($hand->isFullHouse());
    
    $hand->setCards([
      new Card('D3'),
      new Card('H3'),
      new Card('C3'),
      new Card('D7'),
      new Card('H7'),
      new Card('C7'),
      new Card('D9'),
    ]);
    
    $this->assertTrue($hand->isFullHouse());
    
    
    // Absurd test because why would you play a full house instead of a quad 
    // but it IS a full house.
    $hand->setCards([
      new Card('D3'),
      new Card('H3'),
      new Card('C3'),
      new Card('D7'),
      new Card('H7'),
      new Card('S7'),
      new Card('C7'),
    ]);
    
    $this->assertTrue($hand->isFullHouse());
    
    // Sanity Check. LOL
    $hand->setCards([
      new Card('D3'),
      new Card('H3'),
      new Card('C4'),
      new Card('D2'),
      new Card('H2'),
      new Card('S7'),
      new Card('C7'),
    ]);
    
    $this->assertFalse($hand->isFullHouse());
  }
  
  public function testStraight()
  {
    $hand = new Hand;
    $hand->setCards([
      new Card('D5'),
      new Card('D2'),
      new Card('D3'),
      new Card('D4'),
      new Card('D1'),
      new Card('D6'),
      new Card('D7'),
    ]);
    
    $this->assertTrue($hand->isStraight());
    
    $hand = new Hand;
    $hand->setCards([
      new Card('D1'),
      new Card('D2'),
      new Card('D5'),
      new Card('D6'),
      new Card('D7'),
      new Card('D8'),
      new Card('D9'),
    ]);
    
    $this->assertTrue($hand->isStraight());
    
    $hand->setCards([
      new Card('D2'),
      new Card('D3'),
      new Card('D4'),
      new Card('D5'),
      new Card('D7'),
      new Card('D8'),
      new Card('D9'),
    ]);
    
    $this->assertFalse($hand->isStraight());
    
    // Royal Straight
    
    $hand = new Hand;
    $hand->setCards([
      new Card('D1'),
      new Card('D13'),
      new Card('D12'),
      new Card('D11'),
      new Card('D10'),
      new Card('D5'),
      new Card('D4'),
    ]);
    
    $this->assertTrue($hand->isStraight());
  }
}