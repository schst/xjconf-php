<?php
/**
 * Integration test with Example3.
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
 * Integration test with Example3.
 *
 * @package     xjconf
 * @subpackage  integration
 */
class Example3TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * test if example3 works
     *
     * @test
     */
    public function example3()
    {
        $tagParser  = new DefinitionParser();
        $defs       = $tagParser->parse(EXAMPLES_DIR . '/xml/defines3.xml');
        $namespaces = array('http://schst.net/test' => 'http://schst.net/test', 'http://schst.net/bar' => 'http://schst.net/bar');
        foreach ($defs->getDefinedNamespaces() as $key => $namespace) {
            $this->assertEquals($namespaces[$key], $namespace->getNamespaceURI());
        }
        
        $conf = new XmlParser();
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test3.xml');
        
        $this->assertEquals(12, $conf->getConfigValue('zahl'));
        $this->assertEquals("Now the tag 'foo' is used as a string", $conf->getConfigValue('text'));
    }
}
?>