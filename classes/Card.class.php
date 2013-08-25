<?php 

/**
* Card
*/
class Card
{
  private $number;
  private $suit;
  
  public function __construct($code)
  {
    $this->suit = substr($code, 0, 1);
    $this->number = substr($code, 1);
  }
  
  public function __toString()
  {
    return $this->suit . $this->number;
  }
}
