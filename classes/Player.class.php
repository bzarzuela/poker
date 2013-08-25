<?php 

/**
* Player
*/
class Player
{
  private $name;
  private $cards = [];
  
  public function __toString()
  {
    return $this->name;
  }
  
  public function setName($name)
  {
    $this->name = $name;
    return $this;
  }
  
  public function setCards($cards)
  {
    $this->cards = $cards;
  }
  
  public function peekAtCards($community_cards)
  {
    $hand = new Hand;
    $hand->setCards($community_cards + $this->cards);
    
    if ($hand->isStraightFlush()) {
      return Hand::STRAIGHT_FLUSH;
    }
    
    if ($hand->isQuad()) {
      return Hand::QUAD;
    }
    
    if ($hand->isFullHouse()) {
      return Hand::FULL_HOUSE;
    }
    
    if ($hand->isFlush()) {
      return Hand::FLUSH;
    }
    
    if ($hand->isStraight()) {
      return Hand::STRAIGHT;
    }
    
    if ($hand->isTriple()) {
      return Hand::TRIPLE;
    }
    
    if ($hand->isTwoPair()) {
      return Hand::TWO_PAIR;
    }
    
    if ($hand->isPair()) {
      return Hand::PAIR;
    }
    
    return Hand::HIGH_CARD;
  }
}
