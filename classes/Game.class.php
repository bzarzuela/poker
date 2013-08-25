<?php

/**
* Game
*/
class Game
{
  private $players = [];
  
  private $logger;
  
  private $deck;
  
  private $community_cards = [];
  
  public function __construct()
  {
    $this->deck = new Deck;
  }
  
  public function addPlayer(Player $player)
  {
    $this->players[] = $player;
    $this->logger->debug("$player has entered the game");
    return $this;
  }
  
  public function setLogger(Logger $logger)
  {
    $this->logger = $logger;
    return $this;
  }
  
  public function deal()
  {
    $this->deck->shuffle();
    $this->community_cards = $this->deck->draw(5);
    
    $this->logger->debug('Community Cards: ' . implode(', ', $this->community_cards));
    
    foreach ($this->players as $player) {
      $cards = $this->deck->draw(2);
      $player->setCards($cards);
      
      $this->logger->debug($player . ' Cards: ' . implode(', ', $cards));
    }
  }
}
