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
  
}