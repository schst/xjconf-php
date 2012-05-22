<?php
/**
 * Integration test with Example2.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     xjconf
 * @subpackage  integration
 * @version     $Id$
 */
namespace net\xjconf\integration;
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
/**
 * Integration test with Example1.
 *
 * @package     xjconf
 * @subpackage  integration
 */
class Example2TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * test if example2 works
     *
     * @test
     */
    public function example2()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(EXAMPLES_DIR . '/xml/defines2.xml');
        $this->assertEquals(3, $defs->countTagDefinitions());
        
        $conf = new XmlParser();
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test2.xml');
        
        $this->assertEquals(452, $conf->getConfigValue('one'));
        $this->assertEquals(1452, $conf->getConfigValue('two'));
        $this->assertEquals(13, $conf->getConfigValue('three'));
        $this->assertEquals(array('blue', 'purple'), $conf->getConfigValue('colors'));
    }
}
?>