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
  
  private $winner;
  
  // For the lulz
  private $challenger;
  
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
    $this->setCommunityCards($this->deck->draw(5));
    
    $this->logger->debug('Community Cards: ' . implode(', ', $this->getCommunityCards()));
    
    foreach ($this->players as $player) {
      $cards = $this->deck->draw(2);
      $player->setCards($cards);
      
      $this->logger->debug($player . ' Cards: ' . implode(', ', $cards));
    }
  }
  
  public function play()
  {
    $hands = [];
    foreach ($this->players as $player) {
      $rank = $player->peekAtCards($this->community_cards);
      $this->logger->debug($player . ' Hand: ' . $player->getHand()->getDescription());
      $hands[$rank][] = $player;
    }
    
    $finalists = $hands[max(array_keys($hands))];
    
    $this->logger->debug('Hand: ' . $finalists[0]->getHand()->getDescription());
    
    if (count($finalists) == 1) {
      $this->logger->debug('Winner: ' . $finalists[0]);
      $this->setWinner($finalists[0]);
    } else {
      $this->logger->debug('Finalists: ' . implode(', ', $finalists));
      
      $winner = $finalists[0];
      for ($i=1; $i < count($finalists); $i++) { 
        
        $challenger = $finalists[$i];
        
        // Would love to redo this piece for clarity.
        // It looks more like Ruby than PHP.
        if ($this->is($challenger)->betterThan($winner)) {
          $winner = $challenger;
        }
      }
      
      $this->setWinner($winner);
      $this->logger->debug('Winner: ' . $winner);
    }
    
  }
  
  // Method used for chaining when there are challengers.
  public function betterThan(Player $winner)
  {
    switch ($winner->getHand()->getRank()) {
      case Hand::STRAIGHT_FLUSH:
        return $this->compareStraightFlush($this->challenger, $winner);
      break;
      
      default:
        # code...
      break;
    }
  }
  
  // Method used for chaining when there are challengers.
  public function is(Player $challenger)
  {
    $this->challenger = $challenger;
    return $this;
  }
  
  
  public function setWinner(Player $player) 
  {
    $this->winner = $player;
    return $this;
  }
  
  public function getWinner()
  {
    return $this->winner;
  }
  
  public function setCommunityCards($cards)
  {
    $this->community_cards = $cards;
    return $this;
  }
  
  public function getCommunityCards()
  {
    return $this->community_cards;
  }
  
  /**
   * Straight Flushes are checked against the highest card.
   *
   * @param Player $challenger 
   * @param Player $winner 
   * @return bool
   */
  public function compareStraightFlush($challenger, $winner)
  {
    $challenger_rank = $challenger->getHand()->getHighestCard()->getValue();
    $winner_rank = $winner->getHand()->getHighestCard()->getValue();
    
    $this->logger->debug($challenger . ' Card Value: ' . $challenger_rank);
    $this->logger->debug($winner . ' Card Value: ' . $winner_rank);
    
    if ($challenger_rank > $winner_rank) {
      return true;
    }
    
    if ($challenger_rank < $winner_rank) {
      return false;
    }
    
    if ($challenger_rank == $winner_rank) {
      throw new Exception("The world just ended.");
    }
  }
}
