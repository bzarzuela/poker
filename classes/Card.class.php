<?php 

/**
* Card
*/
class Card
{
  private $number;
  private $suit;
  
  private $friendly_map = [
    1 => 'A',
    11 => 'J',
    12 => 'Q',
    13 => 'K',
  ];
  
  public function __construct($code)
  {
    $this->suit = substr($code, 0, 1);
    $this->number = substr($code, 1);
  }
  
  public function __toString()
  {
    $number = $this->number;

    if (isset($this->friendly_map[$number])) {
      $number = $this->friendly_map[$number];
    }

    return $this->suit . $number;
  }
  
  public function getSuit()
  {
    return $this->suit;
  }
  
  public function getNumber()
  {
    return $this->number;
  }
  
  public function getCode()
  {
    return $this->suit . $this->number;
  }
  
  public function getValue()
  {
    return Deck::getInstance()->getValue($this->getCode());
  }
}
