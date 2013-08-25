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
      
      if (isset($this->suits[$card->getSuit()])) {
        $this->suits[$card->getSuit()]++;
      } else {
        $this->suits[$card->getSuit()] = 1;
      }
      
      if (isset($this->numbers[$card->getNumber()])) {
        $this->numbers[$card->getNumber()]++;
      } else {
        $this->numbers[$card->getNumber()] = 1;
      }
      
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
    foreach ($this->numbers as $number => $count) {
      if ($count == 4) {
        return true;
      }
    }
    
    return false;
  }
}
