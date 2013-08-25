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
  
  public function getBestHand($community_cards)
  {
    $hand = new Hand;
    $hand->setCards($community_cards + $this->cards);
  }
}
