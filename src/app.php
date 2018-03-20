<?php

  ini_set("display_errors", 1);
  error_reporting(E_ALL);

  require (file_exists("./autoload.php")) ? './autoload.php' : '../vendor/autoload.php';

  use Symfony\Component\Console\Application;
  use Yoke\Dispatcher;

  $yoke = new Application();
  $yoke->setName('Yoke: SSH Connection Manager');

  (new Yoke\Dispatcher($yoke))->run();
