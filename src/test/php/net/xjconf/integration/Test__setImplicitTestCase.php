<?php
/**
 * Integration test with implicit __set().
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require_once EXAMPLES_DIR . '/Dog.php';
/**
 * Integration test with implicit __set().
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class Test__setImplicitTestCase extends UnitTestCase
{
    /**
     * test that implicit __set() works
     */
    public function test__setImplicit()
    {
        $tagParser = new DefinitionParser();
        $defs = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-__setImplicit.xml');

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