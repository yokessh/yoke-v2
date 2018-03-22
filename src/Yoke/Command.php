<?php

namespace Yoke\Command;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class YokeCommandCaller
{
    public $app;
    public $input;
    public $output;


    public function __construct(Application $app, InputInterface $input, OutputInterface $output)
    {
        $this->app    = $app;
        $this->input  = $input;
        $this->output = $output;

    }//end __construct()


    public static function Create(Application $app, InputInterface $input, OutputInterface $output): YokeCommandCaller
    {
        return new YokeCommandCaller($app, $input, $output);

    }//end Create()


}//end class


// TODO: Use YokeParameters instead of array
class YokeParameters
{
    public $name;
    public $option;
    public $description;
    public $default;
}//end class


// TODO: Use YokeOption instead of array
class YokeOptions
{
    public $name;
    public $shortcut;
    public $mode;
    public $description;
    public $default;
}//end class


class YokeCommand
{
    public $name;
    public $description;
    public $args;
    public $options;


    public function __construct(string $name, string $description, array $args, array $options)
    {
        $this->name        = $name;
        $this->description = $description;
        $this->args        = $args;
        $this->options     = $options;

    }//end __construct()


    public function registry(Application $app, bool $asDefault=false)
    {
        $command = $app->register($this->name);
        $command->setDescription($this->description);
        foreach ($this->args as $arg) {
            call_user_func_array([$command, 'addArgument'], $arg);
        }

        foreach ($this->options as $option) {
            call_user_func_array([$command, 'addOption'], $option);
        }

        $command->setCode(
            function (InputInterface $input, OutputInterface $output) use ($app) {
                $this->dispatch($input->getArguments(), $input->getOptions(), YokeCommandCaller::Create($app, $input, $output));
            }
        );

        if ($asDefault) {
            $app->setDefaultCommand($CMD['name'], true);
        }

    }//end registry()


    public function dispatch(array $args, array $options, YokeCommandCaller $commandBase)
    {
        $argsData = [];
        foreach ($this->args as $arg) {
            // argument name = $args[0]
            $argsData[$arg[0]] = $args[$arg[0]];
        }

        call_user_func_array([$this, 'run'], array_merge($argsData, [$options, $commandBase]));

    }//end dispatch()


}//end class
