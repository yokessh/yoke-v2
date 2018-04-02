<?php

use PHPUnit\Framework\TestCase;

use PHP_CodeSniffer\Runner;

require __DIR__.'/../../vendor/squizlabs/php_codesniffer/autoload.php';

class PRSTest extends TestCase
{
    // PSR Rules Version
    const PSR_STANDARDS = 'PSR2';

    private $runner;


    private function PSRBaseArgs(array $args)
    {
        return array_merge(['--standard='.PRSTest::PSR_STANDARDS, '--extensions=php,inc,lib'], $args);

    }//end PSRBaseArgs()


    private function PRSRunner(array $args)
    {
        $currentServerArgs = $_SERVER['argv'];
        // TODO: Add a manner to avoid DocComments rules
        $_SERVER['argv'] = $this->PSRBaseArgs($args);

        ob_start();
        $exitCode = $this->runner->runPHPCS();
        $report   = ob_get_contents();
        ob_end_clean();

        $_SERVER['argv'] = $currentServerArgs;

        return [
            $exitCode,
            $report,
        ];

    }//end PRSRunner()


    private function PRSFixer(array $args)
    {
        $currentServerArgs = $_SERVER['argv'];
        // TODO: Add a manner to avoid DocComments rules
        $_SERVER['argv'] = $this->PSRBaseArgs($args);

        ob_start();
        $exitCode = $this->runner->runPHPCBF();
        $report   = ob_get_contents();
        ob_end_clean();

        $_SERVER['argv'] = $currentServerArgs;

        return [
            $exitCode,
            $report,
        ];

    }//end PRSFixer()


    public function testPRS()
    {
        $this->runner = new PHP_CodeSniffer\Runner();

        list($exitCode, $codeReport)   = $this->PRSRunner(['--report=code', 'src/']);
        list($exitCode, $sourceReport) = $this->PRSRunner(['--report=source', 'src/']);

        // exitCode sign a fault on the standards
        if ($exitCode !== 0) {
            // Save the report for future uses.
            file_put_contents(__DIR__.'/PSR_errors.report', $codeReport.$sourceReport);

            /*
                * Call Fixer to automate some possible fixes
             */
            list($exitFixerCode, $fixReportSrc) = $this->PRSFixer(['src/']);

            // Can't fix itself
            list($exitFixerCode, $fixReportTest) = $this->PRSFixer(['test/']);

            file_put_contents(__DIR__.'/PSR_fix.report', $fixReportSrc.$fixReportTest);
        } else {
        }

        $this->assertEquals($exitCode, 0, 'For God\'s sake! PSR didn\'t pass!');

    }//end testPRS()


}//end class
