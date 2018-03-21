<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// auto-loader
require (file_exists('./autoload.php'))
    ? './autoload.php'
    : '../vendor/autoload.php';

use Symfony\Component\Console\Application;

use Yoke\Dispatcher;

// Start up the application and set it a name
$yoke = new Application();
$yoke->setName('Yoke: SSH Connection Manager');

// Run the application wrapped on the Dispatcher
(new Yoke\Dispatcher($yoke))->run();
