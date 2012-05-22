<?php
/**
 * Test runner for XJConf.
 *
 * @author  Frank Kleine <mikey@xjconf.net>
 */
define('TEST_CWD', __DIR__);
define('EXAMPLES_DIR', realpath(__DIR__ . '/../examples'));
require_once TEST_CWD . '/../simpletest/reporter.php';
require_once TEST_CWD . '/../simpletest/unit_tester.php';
require_once TEST_CWD . '/../src/main/php/net/xjconf/XJConf.php';
/**
 * Test runner for XJConf.
 *
 * @package     XJConf
 * @subpackage  test
 */
class XJConfIntegrationTestRunner
{
    public function main()
    {
        $test = new TestSuite('Integration tests');
        $test->addTestFile(TEST_CWD . '/integration/Example1TestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/Example2TestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/Example3TestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/ExampleClassLoaderTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/ExampleCollectionTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/ExampleExtensionTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/Test__setExplicitTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/Test__setImplicitTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/Test__setPublicPropertiesTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/TestAttributesRequiredTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/TestAutoPrimitivesTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/TestCDataSetterTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/TestConstructorTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/TestDynamicSettersTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/TestDynamicTypesTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/TestEmptyConstructorTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/TestInterfacesTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/TestPrimitivesFactoryTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/TestPrimitivesTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/TestStaticClassTestCase.php');
        $test->addTestFile(TEST_CWD . '/integration/TestXIncludeTestCase.php');
        if (PHP_SAPI == 'cli') {
            $reporter = new TextReporter();
        } else {
            $reporter = new HtmlReporter();
        }
        $test->run($reporter);
    }
}
XJConfIntegrationTestRunner::main();
?>