<?php

namespace Yoke;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

// Yoke Commands
use Yoke\Commands\EchoCommand;

class Dispatcher
{
    private $app;


    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->Prepare();

    }//end __construct()


    public function prepare()
    {
        (new EchoCommand())->registry($this->app);

    }//end prepare()


    public function run()
    {
        $this->app->Run();

    }//end run()


}//end class
