<?php
/**
 * Integration test with explicit __set().
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require_once EXAMPLES_DIR . '/Dog.php';
/**
 * Integration test with explicit __set().
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class Test__setExplicitTestCase extends UnitTestCase
{
    /**
     * test that explicit __set() works
     */
    public function test__setExplicit()
    {
        $tagParser = new DefinitionParser();
        $defs = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-__setExplicit.xml');

        $conf = new XmlParser();
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test-__set.xml');

        $dog = $conf->getConfigValue('dog');
        $this->assertIsA($dog, 'Dog');
        $this->assertEqual($dog->getProperties(), array('species' => 'Sausage dog',
                                                        'name'     => 'Waldemar'
                                                  )
        );
    }
}
?>