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
  private $kicker = null;
  
  // Used in one pair tie-breakers
  private $kickers = [];
  
  // Used for tie-breakers for triple and two pairs.
  private $highest_triple = null;
  private $highest_pair = [];
  
  private $rank = 0;
  
  const HIGH_CARD = 1;
  const PAIR = 2;
  const TWO_PAIR = 3;
  const TRIPLE = 4;
  const STRAIGHT = 5;
  const FLUSH = 6;
  const FULL_HOUSE = 7;
  const QUAD = 8;
  const STRAIGHT_FLUSH = 9;
  
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
    $cards = $this->cards;
    foreach ($cards as $suit => $numbers) {
      if (count($numbers) >= 5) {
        
        foreach ($numbers as $card) {
          if (!$card->isCommunity()) {
            $this->kicker = ($card->getNumber() > $this->kicker) ? $card->getNumber() : $this->kicker;
          }
        }
        
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
    $ret = $this->countPairs(4);
    if ($ret) {
      // Set the highest kicker for later comparison
      $numbers = $this->numbers;
      $this->kicker = 0;
      foreach ($numbers as $number => $cards) {
        if (count($cards) != 4) {
          foreach ($cards as $card) {
            if ($card->getNumber() > $this->kicker) {
              $this->kicker = $card->getNumber();
            }
          }
        }
      }
    }
    
    return $ret;
  }
  
  public function isTriple()
  {
    $ret = $this->countPairs(3);
    
    if ($ret) {
      $numbers = $this->numbers;
      $this->highest_triple = 0;
      foreach ($numbers as $number => $cards) {
        if (count($cards) == 3) {
          $this->highest_triple = $cards[0]->getNumber();
        }
      }
    }
    
    return $ret;
  }
  
  public function isPair()
  {
    $numbers = $this->numbers;
    $ret = false;
    
    foreach ($numbers as $number => $cards) {
      if (count($cards) == 2) {
        unset($numbers[$number]);
        $this->highest_pair[1] = $cards[0]->getNumber();
        $ret = true;
      }
    }
    
    if ($ret) {
      foreach ($numbers as $number => $cards) {
        $this->kickers[$cards[0]->getValue()] = $cards[0]->getNumber();
      }
    }
    
    return $ret;
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
        $this->kicker = $cards[0]->getNumber();
        break;
      }
    }
    
    return $has_triple and $has_pair;
  }
  
  public function getHighestCard()
  {
    return $this->highest_card;
  }
  
  public function getLowestNumber()
  {
    return min(array_keys($this->numbers));
  }
  
  public function isStraight()
  {
    $numbers = array_keys($this->numbers);
    rsort($numbers);
    
    $is_straight = false;
    
    foreach ($numbers as $base) {
      $target = $base - 4;
      if (in_array($target, $numbers)) {
        for ($i=4; $i >= 1; $i--) { 
          $target = $base - $i;
          if (!in_array($target, $numbers)) {
            continue 2;
          }
        }
        
        $this->kicker = $numbers[4];
        
        $is_straight = true;
      }
    }
    
    // One final check for a royal straight.
    if ($numbers[max(array_keys($numbers))] == 1) {
      for ($i=13; $i >= 10; $i--) { 
        if (!in_array($i, $numbers)) {
          goto no_chance;
        }
      }
      
      $this->kicker = 14; // Special case for Aces in Royal Straights
      
      $is_straight = true;
    }
    
    // I used goto! Woohoo!
    no_chance:
    return $is_straight;
  }
  
  public function isStraightFlush()
  {
    if (!$this->isStraight()) {
      return false;
    }
    
    if (!$this->isFlush()) {
      return false;
    }
    
    // Check if both the straight and flush cards are the same.
    $numbers = [];
    foreach ($this->suits as $cards) {
      if (count($cards) >= 5) {
        foreach ($cards as $card) {
          $numbers[] = $card->getNumber();
        }
        break;
      }
    }
    
    sort($numbers);
    
    $checks_out = false;
    
    $base = $numbers[0];
    
    $target = $base + 4;
    if (in_array($target, $numbers)) {
      for ($i=1; $i <= 4; $i++) { 
        $target = $base + $i;
        if (!in_array($target, $numbers)) {
          goto no_chance;
        }
      }
      
      $checks_out = true;
    }
    
    // One final check for a royal flush.
    if ($base == 1) {
      for ($i=13; $i >= 10; $i--) { 
        if (!in_array($i, $numbers)) {
          goto no_chance;
        }
      }
      
      $checks_out = true;
    }
    
    no_chance:
    return $checks_out;
  }
  
  public function isTwoPair()
  {
    $numbers = $this->numbers;
    rsort($numbers);
    $pairs = [
      1 => false,
      2 => false,
    ];
    
    for ($i=1; $i <= 2; $i++) { 
      foreach ($numbers as $number => $cards) {
        if (count($cards) >= 2) {
          $pairs[$i] = true;
          $this->highest_pair[$i] = $cards[0]->getNumber();
          unset($numbers[$number]);
          break;
        }
      }
    }
    
    return $pairs[1] and $pairs[2];
  }
  
  public function compute()
  {
    if ($this->isStraightFlush()) {
      $this->setRank(Hand::STRAIGHT_FLUSH);
      return $this;
    }
    
    if ($this->isQuad()) {
      $this->setRank(Hand::QUAD);
      return $this;
    }
    
    if ($this->isFullHouse()) {
      $this->setRank(Hand::FULL_HOUSE);
      return $this;
    }
    
    if ($this->isFlush()) {
      $this->setRank(Hand::FLUSH);
      return $this;
    }
    
    if ($this->isStraight()) {
      $this->setRank(Hand::STRAIGHT);
      return $this;
    }
    
    if ($this->isTriple()) {
      $this->setRank(Hand::TRIPLE);
      return $this;
    }
    
    if ($this->isTwoPair()) {
      $this->setRank(Hand::TWO_PAIR);
      return $this;
    }
    
    if ($this->isPair()) {
      $this->setRank(Hand::PAIR);
      return $this;
    }
    
    $this->setRank(Hand::HIGH_CARD);
    return $this;
  }
  
  public function setRank($rank)
  {
    $this->rank = $rank;
    return $this;
  }
  
  public function getRank()
  {
    return $this->rank;
  }
  
  public function getDescription()
  {
    $map = [
      9 => 'Straight flush',
      8 => 'Four of a kind',
      7 => 'Full house',
      6 => 'Flush',
      5 => 'Straight',
      4 => 'Three of a kind',
      3 => 'Two pair',
      2 => 'One pair',
      1 => 'High Card',
    ];
    
    if (!isset($map[$this->rank])) {
      throw new Exception("Hand not computed");
    }
    
    return $map[$this->rank];
    
  }
  
  public function getKicker()
  {
    return $this->kicker;
  }
  
  public function getHighestTriple()
  {
    return $this->highest_triple;
  }
  
  public function getHighestPair()
  {
    return $this->highest_pair;
  }
  
  public function getKickers()
  {
    return $this->kickers;
  }
}
