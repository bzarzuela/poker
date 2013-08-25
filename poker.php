<?php 

spl_autoload_register(function ($class) {
  include 'classes/' . $class . '.class.php';
});

$players = isset($_SERVER['argv'][1]) ? $_SERVER['argv'] : rand(2, 6);

$game = new Game;
$game->setLogger(new Logger);

for ($i=1; $i <= $players; $i++) { 
  $player = new Player;
  $player->setName('Player ' . $i);
  
  $game->addPlayer($player);
}

$game->deal();