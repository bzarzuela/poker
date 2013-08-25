<?php 

spl_autoload_register(function ($class) {
  include 'classes/' . $class . '.class.php';
});

$players = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : rand(2, 6);

if ($players < 2 or $players > 6) {
  die('Number of players must be between 2 to 6');
}

$game = new Game;
$game->setLogger(new Logger);

for ($i=1; $i <= $players; $i++) { 
  $player = new Player;
  $player->setName('Player ' . $i);
  
  $game->addPlayer($player);
}

$game->deal();