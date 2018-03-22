<?php

namespace Yoke\Commands;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Yoke\Command\YokeCommand;
use Yoke\Command\YokeCommandCaller;

class EchoCommand extends YokeCommand
{


    public function __construct()
    {
        parent::__construct(
            'echo',
            'Echo is used to test out the parameters',
            [
                [
                    'text',
                    InputArgument::REQUIRED,
                    'The text to be printed out',
                ],
            ],
            [
                [
                    'param1',
                    null,
                    InputOption::VALUE_REQUIRED,
                ],
            ]
        );

    }//end __construct()


    public function run(string $text, array $options, YokeCommandCaller $commandBase)
    {
        $param1 = ($options['param1'] != '') ? sprintf(' [bar = %s]', $options['param1']) : '';

        $commandBase->output->write(sprintf('Echo: %s', $text).$param1);

    }//end run()


}//end class
