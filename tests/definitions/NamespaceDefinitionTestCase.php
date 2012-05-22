<?php
/**
 * Test for NamespaceDefinition.
 *
 * @author  Frank Kleine <mikey@xjconf.net>
 */
use net\xjconf\definitions\NamespaceDefinition;
Mock::generate('net\xjconf\definitions\TagDefinition', 'MockTagDefinition');
/**
 * Test for NamespaceDefinition.
 *
 * @package     XJConf
 * @subpackage  test_definitions
 */
class NamespaceDefinitionTestCase extends UnitTestCase
{
    /**
     * instance to test
     *
     * @var  NamespaceDefinition
     */
    protected $namespaceDefinition;
    
    /**
     * set up test resources
     */
    public function setUp()
    {
        $this->namespaceDefinition = new NamespaceDefinition('http://example.org/test');
    }
    
    /**
     * test if construction works
     */
    public function testConstruct()
    {
        $this->assertEqual($this->namespaceDefinition->getNamespaceURI(), 'http://example.org/test');
        $this->assertEqual($this->namespaceDefinition->countTagDefinitions(), 0);
    }
    
    /**
     * test that the definition handling is as expected
     */
    # does not work to missing interface, mocking gives not correct instance
    /*public function testDefinitionHandling()
    {
        $mock1 = new MockTagDefinition();
        $mock2 = new MockTagDefinition();
        $mock1->setReturnValue('getTagName', 'mock1');
        $mock2->setReturnValue('getTagName', 'mock2');
        
        $this->assertFalse($this->namespaceDefinition->isDefined('mock1'));
        $this->assertNull($this->namespaceDefinition->getDefinition('mock1'));
        $this->assertFalse($this->namespaceDefinition->isDefined('mock2'));
        $this->assertNull($this->namespaceDefinition->getDefinition('mock2'));
        
        $this->namespaceDefinition->addTagDefinition($mock1);
        $this->assertTrue($this->namespaceDefinition->isDefined('mock1'));
        $this->assertReference($this->namespaceDefinition->getDefinition('mock1'), $mock1);
        $this->assertFalse($this->namespaceDefinition->isDefined('mock2'));
        $this->assertNull($this->namespaceDefinition->getDefinition('mock2'));
        $this->assertEqual($this->namespaceDefinition->countTagDefinitions(), 1);
        
        $this->namespaceDefinition->addTagDefinition($mock2);
        $this->assertTrue($this->namespaceDefinition->isDefined('mock1'));
        $this->assertReference($this->namespaceDefinition->getDefinition('mock1'), $mock1);
        $this->assertTrue($this->namespaceDefinition->isDefined('mock2'));
        $this->assertReference($this->namespaceDefinition->getDefinition('mock2'), $mock2);
        $this->assertEqual($this->namespaceDefinition->countTagDefinitions(), 2);
    }*/
}
?>