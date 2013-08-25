<?php

/**
* Hand
*/
class Hand
{
  private $cards = [];
  
  public function setCards($cards)
  {
    $this->cards = [];
    
    foreach ($cards as $card) {
      $this->cards[$card->getSuit()][$card->getNumber()] = $card;
    }
    return $this;
  }
  
  public function isFlush()
  {
    foreach ($this->cards as $suit => $numbers) {
      if (count($numbers) >= 5) {
        return true;
      }
    }
    
    return false;
  }
}
