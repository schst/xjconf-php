<?php
/**
 * Test runner for XJConf.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test
 */
require_once __DIR__ . '/../simpletest/unit_tester.php';
require_once __DIR__ . '/../simpletest/mock_objects.php';
require_once __DIR__ . '/../simpletest/reporter.php';
require_once __DIR__ . '/../XJConf/XJConf.php';
/**
 * Test runner for XJConf.
 *
 * @package     XJConf
 * @subpackage  test
 */
class XJConfTestRunner
{
    public function main()
    {
        $testSuite = new TestSuite('All tests.');
        $testSuite->addTestFile(__DIR__ . '/converters/ConvertersTestSuite.php');
        $testSuite->addTestFile(__DIR__ . '/definitions/DefinitionsTestSuite.php');
        if (PHP_SAPI == 'cli') {
            $reporter = new TextReporter();
        } else {
            $reporter = new HtmlReporter();
        }
        $testSuite->run($reporter);
    }
}
XJConfTestRunner::main();
?>