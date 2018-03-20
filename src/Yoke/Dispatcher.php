<?php

  namespace Yoke;

  use Symfony\Component\Console\Application;
  use Symfony\Component\Console\Input\InputArgument;
  use Symfony\Component\Console\Input\InputInterface;
  use Symfony\Component\Console\Input\InputOption;
  use Symfony\Component\Console\Output\OutputInterface;

  //use Yoke\Commands\BaseCommand;
  use \Yoke\Commands\EchoCommand;

  class Dispatcher {
      private $_app;

      public function __construct($app) {
        $this->_app = $app;
        $this->Prepare();
      }

      public function prepare(){
        (new EchoCommand())->Register($this->_app);
      }

      public function run(){
        $this->_app->Run();
      }
  }
