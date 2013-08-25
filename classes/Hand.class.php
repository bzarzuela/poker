<?php

/**
* Hand
*/
class Hand
{
  private $cards = [];
  private $suits = [];
  private $numbers = [];
  private $highest_card = null;
  
  
  public function setCards($cards)
  {
    $this->cards = [];
    $this->suits = [];
    $this->numbers = [];
    $this->highest_card = null;
    
    $highest_value = 0;
    
    foreach ($cards as $card) {
      $this->cards[$card->getSuit()][$card->getNumber()] = $card;
      
      $this->suits[$card->getSuit()][] = $card;
      $this->numbers[$card->getNumber()][] = $card;
      
      if ($card->getValue() > $highest_value) {
        $highest_value = $card->getValue();
        $this->highest_card = $card;
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
  
  private function countPairs($target)
  {
    foreach ($this->numbers as $number => $cards) {
      if (count($cards) == $target) {
        return true;
      }
    }
    
    return false;
  }
  
  public function isQuad()
  {
    return $this->countPairs(4);
  }
  
  public function isTriple()
  {
    return $this->countPairs(3);
  }
  
  public function isPair()
  {
    return $this->countPairs(2);
  }
  
  public function isFullHouse()
  {
    $has_triple = false;
    $has_pair = false;
    
    $numbers = $this->numbers;
    foreach ($numbers as $number => $cards) {
      if (count($cards) == 3) {
        $has_triple = true;
        unset($numbers[$number]);
        break;
      }
    }
    
    foreach ($numbers as $number => $cards) {
      if (count($cards) >= 2) {
        $has_pair = true;
        break;
      }
    }
    
    return $has_triple and $has_pair;
  }
  
  public function getHighestCard()
  {
    return $this->highest_card;
  }
}
