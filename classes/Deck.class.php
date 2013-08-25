<?php 

/**
* Deck
*/
class Deck
{
  // Highest index becomes the highest numerical value of the card.
  private $value_map = [
    'C2','C3', 'C4', 'C5', 'C6', 'C7', 'C8', 'C9', 'C10', 'C11', 'C12', 'C13', 'C1',
    'S2','S3', 'S4', 'S5', 'S6', 'S7', 'S8', 'S9', 'S10', 'S11', 'S12', 'S13', 'S1',
    'H2','H3', 'H4', 'H5', 'H6', 'H7', 'H8', 'H9', 'H10', 'H11', 'H12', 'H13', 'H1',
    'D2','D3', 'D4', 'D5', 'D6', 'D7', 'D8', 'D9', 'D10', 'D11', 'D12', 'D13', 'D1',
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
