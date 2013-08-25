<?php 

/**
* Deck
*/
class Deck
{
  // Highest index becomes the highest numerical value of the card.
  private $value_map = [
    'C2','C3', 'C4', 'C5', 'C6', 'C7', 'C8', 'C9', 'C10', 'CJ', 'CQ', 'CK', 'CA',
    'S2','S3', 'S4', 'S5', 'S6', 'S7', 'S8', 'S9', 'S10', 'SJ', 'SQ', 'SK', 'SA',
    'H2','H3', 'H4', 'H5', 'H6', 'H7', 'H8', 'H9', 'H10', 'HJ', 'HQ', 'HK', 'HA',
    'D2','D3', 'D4', 'D5', 'D6', 'D7', 'D8', 'D9', 'D10', 'DJ', 'DQ', 'DK', 'DA',
  ];
  
  private $shuffled = [];
  
  public function getValue($code)
  {
    $value = array_search($code, $this->value_map);
    if (false === $value) {
      throw new Exception("Invalid Card Code: $code");
    }
    
    return $value;
  }
  
  public function shuffle()
  {
    $deck = [];
    foreach ($this->value_map as $code) {
      $deck[] = new Card($code);
    };
    shuffle($deck);
    $this->shuffled = $deck;
  }
  
  public function draw($count)
  {
    if (empty($this->shuffled)) {
      $this->shuffle();
    }
    
    return array_splice($this->shuffled, 0, $count);
  }
  
  public function count()
  {
    return count($this->shuffled);
  }
}
