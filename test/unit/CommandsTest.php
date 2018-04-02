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

// auto-loader
// TODO: setup phpunit.xml and remove auto-loader on the tests
require is_file(__DIR__.'/../src/autoload.php') === true ? __DIR__.'/../src/autoload.php' : __DIR__.'/../../vendor/autoload.php';

class CommandsTest extends TestCase
{


    /**
     * @dataProvider commandsProvider
     */
    public function testCommand($command, $parameters, $expected)
    {
        // EventDispatcher fulfill a complete test method request
        $dispatcher = new EventDispatcher();

        $application = new Application();
        $application->setDispatcher($dispatcher);
        $application->setAutoExit(false);

        // EventDispatcher callback before a command runs
        $dispatcher->addListener(
            ConsoleEvents::COMMAND,
            function (ConsoleCommandEvent $event) {
                // gets the input instance
                // $input = $event->getInput();
                // gets the output instance
                // $output = $event->getOutput();
                // gets the command to be executed
                // $command = $event->getCommand();
                // gets the application
                // $application = $command->getApplication();
            }
        );

        // Encapsulate the Yoke Dispatcher to the application
        (new Yoke\Dispatcher($application));

        // TODO: Fix the use of the Tester. The use of the full commandline string is not allowed.
        $tester = new ApplicationTester($application);

        // TODO: Stop using the application itself. To mocking something up in the future the ApplicationTester is needed.
        $commandline = sprintf('%s %s', $command, $parameters);
        $output      = new StreamOutput(fopen('php://memory', 'w', false));
        $application->run(new StringInput($commandline), $output);

        rewind($output->getStream());
        $display = stream_get_contents($output->getStream());

        // The Test
        $this->assertEquals($display, $expected);

    }//end testCommand()


    public function commandsProvider()
    {
        // TODO: Correct the data for the ApplicationTester when used.
        return [
            [
                'echo',
                'test',
                'Echo: test',
            ],
            [
                'echo',
                '--param1 123 test',
                'Echo: test [bar = 123]',
            ],
        ];

    }//end commandsProvider()


}//end class
