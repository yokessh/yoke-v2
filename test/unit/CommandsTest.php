<?php

use PHPUnit\Framework\TestCase;

use Yoke\Dispatcher;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Tester\ApplicationTester;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Output\StreamOutput;

use Symfony\Component\EventDispatcher\EventDispatcher;

require (file_exists("./autoload.php")) ? './autoload.php' : '../vendor/autoload.php';

class CommandsTest extends TestCase
{
  /**
   * @dataProvider commandsProvider
   */
  public function testCommand($command, $parameters, $expected)
  {
    $dispatcher = new EventDispatcher();

    $application = new Application();
    $application->setDispatcher($dispatcher);
    $application->setAutoExit(false);

    $dispatcher->addListener(ConsoleEvents::COMMAND, function (ConsoleCommandEvent $event) {
        // gets the input instance
        //$input = $event->getInput();

        // gets the output instance
        //$output = $event->getOutput();

        // gets the command to be executed
        //$command = $event->getCommand();

        // writes something about the command
        //$output->writeln(sprintf('Running command <info>%s</info>', $input));

        // gets the application
        //$application = $command->getApplication();
    });

    (new Yoke\Dispatcher($application));

    $tester = new ApplicationTester($application);

    $commandline = sprintf('%s %s', $command, $parameters);

    $output = new StreamOutput(fopen('php://memory', 'w', false));
    $application->run(new StringInput($commandline), $output);

    rewind($output->getStream());
    $display = stream_get_contents($output->getStream());

    $this->assertEquals($display, $expected);
  }

  public function commandsProvider()
  {
    return [
      ['echo', 'test', 'Echo: test'],
      ['echo', '--bar 123 test', 'Echo: test [bar = 123]'],
    ];
  }
}
