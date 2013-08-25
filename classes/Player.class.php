<?php 

/**
* Player
*/
class Player
{
  private $name;
  
  public function __toString()
  {
    return $this->name;
  }
  
  public function setName($name)
  {
    $this->name = $name;
    return $this;
  }
}
