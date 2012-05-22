<?php
/**
 * Integration test with implicit setting of public properties.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
require_once EXAMPLES_DIR . '/AnotherDog.php';
/**
 * Integration test with implicit setting of public properties.
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class Test__setPublicPropertiesTestCase extends UnitTestCase
{
    /**
     * test that implicit setting of public properties works
     */
    public function test__setPublicProperties()
    {
        $tagParser = new DefinitionParser();
        $defs = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-__setPublicProperties.xml');

        $conf = new XmlParser();
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test-__set.xml');

        $dog = $conf->getConfigValue('dog');
        $this->assertIsA($dog, 'AnotherDog');
        $this->assertEqual($dog->species, 'Sausage dog');
        $this->assertEqual($dog->name, 'Waldemar');
    }
}
?>