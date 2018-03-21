<?php

namespace Yoke\Commands;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EchoCommand extends BaseCommand
{
    public function __construct()
    {
        $this->SetCMD(
            [
                'name' => 'echo',
                'Echo is used to test out the parameters',
                'args' => [
                    ['foo', InputArgument::REQUIRED, 'The directory']
                ],
                'options' => [
                    ['bar', null, InputOption::VALUE_REQUIRED]
                ]
            ]
        );
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        $foo = $input->getArgument('foo');
        $bar = $input->getOption('bar');
        $output->write(sprintf('Echo: %s', $foo) .
            (($bar != '')
                ? sprintf(' [bar = %s]', $bar)
                : ''));
    }
}
