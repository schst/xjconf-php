<?php
/**
 * Test suite for all definitions.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test
 */
/**
 * Test suite for all definitions.
 *
 * @package     XJConf
 * @subpackage  test
 */
class DefinitionsTestSuite extends TestSuite
{
    /**
     * constructor
     */
    public function __construct()
    {
        $this->TestSuite('All definition tests');
        $this->addTestFile(__DIR__ . '/AttributeDefinitionTestCase.php');
        $this->addTestFile(__DIR__ . '/CDataDefinitionTestCase.php');
        $this->addTestFile(__DIR__ . '/ConstructorDefinitionTestCase.php');
        $this->addTestFile(__DIR__ . '/FactoryMethodDefinitionTestCase.php');
        $this->addTestFile(__DIR__ . '/NamespaceDefinitionTestCase.php');
    }
}
?>