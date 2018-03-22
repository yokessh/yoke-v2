<?php

use PHPUnit\Framework\TestCase;

use PHP_CodeSniffer\Runner;

require (__DIR__.'/../../vendor/squizlabs/php_codesniffer/autoload.php');

class PRSTest extends TestCase
{
    public function testPRS2(){
        $runner   = new PHP_CodeSniffer\Runner();
        $_SERVER['argv'] = ['--standard=PSR2', '--extensions=php,inc,lib', '--report=code', 'src/'];
        $runner->runPHPCS();
        //$exitCode = $runner->runPHPCS();

        //$runner   = new PHP_CodeSniffer\Runner();
        $_SERVER['argv'] = ['--standard=PSR2', '--extensions=php,inc,lib', '--report=source', 'src/'];
        $runner->runPHPCS();
        //$exitCode = $runner->runPHPCS();
        //exit($exitCode);
    }
}
