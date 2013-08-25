<?php 

/**
* Player
*/
class Player
{
  private $name;
  private $cards = [];
  private $hand = null;
  
  public function __toString()
  {
    return $this->name;
  }
  
  public function setName($name)
  {
    $this->name = $name;
    return $this;
  }
  
  public function getName()
  {
    return $this->name;
  }
  
  public function setCards($cards)
  {
    $this->cards = $cards;
  }
  
  public function peekAtCards($community_cards)
  {
    $hand = new Hand;
    $hand->setCards(array_merge($community_cards,$this->cards));
    $hand->compute();
    $this->hand = $hand;
    return $hand->getRank();
  }
  
  public function getHand()
  {
    return $this->hand;
  }
}
