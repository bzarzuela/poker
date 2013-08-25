<?php 

include_once __DIR__ . '/../classes/Logger.class.php';

/**
* MockLogger
*/
class MockLogger extends Logger
{
  public function debug($message)
  {
    // Does nothing
  }
}
