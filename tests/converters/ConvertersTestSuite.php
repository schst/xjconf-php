<?php
/**
 * Test suite for all converters.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test
 */
/**
 * Test suite for all converters.
 *
 * @package     XJConf
 * @subpackage  test
 */
class ConvertersTestSuite extends TestSuite
{
    /**
     * constructor
     */
    public function __construct()
    {
        $this->TestSuite('All converter tests');
        $this->addTestFile(__DIR__ . '/PrimitiveValueConverterTestCase.php');
    }
}
?>