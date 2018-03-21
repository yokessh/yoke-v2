<?php

namespace Yoke\Commands;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BaseCommand {

    public $CMD = [
        'name' => '',
        'description' => '',
        'args' => [],
        'options' => []
    ];

    public function register(Application $app, bool $asDefault = false)
    {
        $CMD = $this->CMD;

        $command = $app->register($CMD['name']);
        $command->setDescription($CMD['description']);
        foreach ($CMD['args'] as $arg) {
            call_user_func_array([$command, 'addArgument'], $arg);
        }

        foreach ($CMD['options'] as $option) {
            call_user_func_array([$command, 'addOption'], $option);
        }

        $command->setCode(function (InputInterface $input, OutputInterface $output) {
            $this->Run($input, $output);
        });

        if ($asDefault) {
            $app->setDefaultCommand($CMD['name'], true);
        }
    }

    public function setCMD(array $cmd)
    {
        $this->CMD = array_merge($this->CMD, $cmd);
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        //
    }
}
