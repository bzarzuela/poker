<?php

/**
* Hand
*/
class Hand
{
  private $cards = [];
  private $suits = [];
  private $numbers = [];
  
  
  
  public function setCards($cards)
  {
    $this->cards = [];
    
    foreach ($cards as $card) {
      $this->cards[$card->getSuit()][$card->getNumber()] = $card;
      
      $this->suits[$card->getSuit()][] = $card;
      $this->numbers[$card->getNumber()][] = $card;
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
  
  public function isQuad()
  {
    foreach ($this->numbers as $number => $cards) {
      if (count($cards) == 4) {
        return true;
      }
    }
    
    return false;
  }
}
