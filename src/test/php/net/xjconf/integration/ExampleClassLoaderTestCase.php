<?php
/**
 * Integration test with ExampleClassLoader.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_integration
 */
use net\xjconf\DefinitionParser;
use net\xjconf\XmlParser;
use net\xjconf\examples\ClassLoader;
/**
 * Integration test with ExampleClassLoader.
 *
 * @package     XJConf
 * @subpackage  test_integration
 */
class ExampleClassLoaderTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * test if using a class loader works
     *
     * @test
     */
    public function exampleClassLoader()
    {
        $tagParser = new DefinitionParser(array('http://xjconf.net/example/ClassLoader' => new ClassLoader()));
        $defs      = $tagParser->parse(EXAMPLES_DIR . '/xml/defines-classloader.xml');
        
        $conf = new XmlParser();
        $conf->setTagDefinitions($defs);
        $conf->parse(EXAMPLES_DIR . '/xml/test-classloader.xml');
        
        $this->assertType('net\xjconf\examples\hidden\MyNestedClass', $conf->getConfigValue('nestedClass'));
        $this->assertType('net\xjconf\examples\MyClass', $conf->getConfigValue('otherClass'));
    }
}
?>