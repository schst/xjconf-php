<?php
/**
 * Class to organize all integration tests.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     xjconf
 * @subpackage  integration
 * @version     $Id: IntegrationTests.php 145 2008-12-27 13:30:19Z mikey $
 */
ini_set('memory_limit', -1);
if (defined('PHPUnit_MAIN_METHOD') === false) {
    define('PHPUnit_MAIN_METHOD', 'src_test_IntegrationTests::main');
}
#../src/main/php/net/xjconf/examples/
define('TEST_SRC_PATH', __DIR__);
define('EXAMPLES_DIR', realpath(__DIR__ . '/../main/resources/examples'));
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';
require_once 'PHPUnit/Util/Filter.php';
require_once __DIR__ . '/../main/php/net/xjconf/XJConf.php';
PHPUnit_Util_Filter::addDirectoryToWhitelist(realpath(__DIR__ . '/../main/php/net/xjconf'));
/**
 * Class to organize all integration tests.
 *
 * @package     xjconf
 * @subpackage  integration
 */
class src_test_IntegrationTests extends PHPUnit_Framework_TestSuite
{
    /**
     * runs this test suite
     */
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    /**
     * returns the test suite to be run
     *
     * @return  PHPUnit_Framework_TestSuite
     */
    public static function suite()
    {
        $suite = new self();
        $suite->addTestFile(__DIR__ . '/php/net/xjconf/integration/Example1TestCase.php');
        $suite->addTestFile(__DIR__ . '/php/net/xjconf/integration/Example2TestCase.php');
        $suite->addTestFile(__DIR__ . '/php/net/xjconf/integration/Example3TestCase.php');
        $suite->addTestFile(__DIR__ . '/php/net/xjconf/integration/ExampleClassLoaderTestCase.php');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD === 'src_test_IntegrationTests::main') {
    src_test_IntegrationTests::main();
}
?>