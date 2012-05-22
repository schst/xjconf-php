<?php
/**
 * Integration test with Example1.
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
class Example1TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * test if example1 works
     *
     * @test
     */
    public function example1()
    {
        $tagParser = new DefinitionParser();
        $defs      = $tagParser->parse(EXAMPLES_DIR . '/xml/defines.xml');
        $this->assertEquals(10, $defs->countTagDefinitions());
        
        $conf = new XmlParser();
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test.xml');
        
        $this->assertEquals('tomato', $conf->getConfigValue('foo'));
        $this->assertEquals(124, $conf->getConfigValue('zahl'));
        $this->assertEquals(0777, $conf->getConfigValue('octal'));
        $this->assertType('net\xjconf\examples\UpperString', $conf->getConfigValue('schst'));
        $this->assertEquals('TOMATO', $conf->getConfigValue('schst')->getString());
        $this->assertType('net\xjconf\examples\Complex', $conf->getConfigValue('complex'));
        $this->assertEquals('<font color="red" size="3">This is a string.</font>', $conf->getConfigValue('complex')->render());
        $this->assertType('net\xjconf\examples\Complex', $conf->getConfigValue('complex2'));
        $this->assertEquals('<font title="This text is written in dark-blue (A dark blue)" color="#01450" size="3"></font>', $conf->getConfigValue('complex2')->render());
        $this->assertEquals(array('foo', 'bar'), $conf->getConfigValue('array'));
        $this->assertType('net\xjconf\examples\Complex', $conf->getConfigValue('complex3'));
        $this->assertEquals('<font color="" size="200"></font>', $conf->getConfigValue('complex3')->render());
    }
}
?>