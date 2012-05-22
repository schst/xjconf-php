<?php
/**
 * Integration test with ExampleCollection.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
/**
 * Integration test with ExampleCollection.
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class ExampleCollectionTestCase extends UnitTestCase
{
    /**
     * test if collections work
     */
    public function testExampleCollection()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-collection.xml');
        
        $conf = new XmlParser();
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test-collection.xml');
        
        $this->assertEqual($conf->getConfigValue('list'), array('one', 'two', 'three'));
    }
}
?>