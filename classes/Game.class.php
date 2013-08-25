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
      
      $rankings = [];
      foreach ($finalists as $finalist) {
        $rankings[$this->rankFinalist($finalist)][] = $finalist;
      }
      
      $highest_rank = max(array_keys($rankings));
      if (count($rankings[$highest_rank]) == 1) {
        $winner = $rankings[$highest_rank][0];
        $this->setWinner($winner);
        $this->logger->debug('Winner: ' . $winner);
      } else {
        $this->logger->debug('A tie between : ' . implode(', ', $rankings[$highest_rank]));
        $this->setWinner($rankings[$highest_rank]);
      }
    }
    
  }
  
  public function rankFinalist($finalist)
  {
    switch ($finalist->getHand()->getRank()) {
      case Hand::STRAIGHT_FLUSH:
        return $finalist->getHand()->getHighestCard()->getValue();
      break;
      
      case Hand::QUAD:
        return $finalist->getHand()->getKicker();
      break;
      
      default:
        # code...
      break;
    }
  }
  
  
  /**
   * In cases of a tie, the $player can be an array of winners.
   *
   * @param mixed $player 
   * @return $this
   */
  public function setWinner($player) 
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
  
  public function compareQuadKicker($challenger, $winner)
  {
    $challenger_rank = $challenger->getHand()->getKicker()->getValue();
    $winner_rank = $winner->getHand()->getKicker()->getValue();
    
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
