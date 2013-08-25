<?php

/**
* Game
*/
class Game
{
  private $players = [];
  
  private $logger;
  
  private $deck;
  
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
    # TODO code...
  }
}
