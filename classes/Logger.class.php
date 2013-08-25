<?php 

class Logger
{
  const DEBUG = 7;
  
  public function debug($message)
  {
    $this->log($message, self::DEBUG);
  }
  
  public function log($message, $level = self::DEBUG)
  {
    echo date('Y-m-d H:i:s ') . $level . ': ' . $message . "\n";
  }
}