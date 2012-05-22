<?php
/**
 * Test for ConstructorDefinition.
 *
 * @author  Frank Kleine <mikey@xjconf.net>
 */
use net\xjconf\definitions\ChildDefinition;
use net\xjconf\definitions\ConstructorDefinition;
Mock::generate('net\xjconf\Tag', 'MockTag');
Mock::generate('net\xjconf\definitions\Definition', 'MockDefinition');
/**
 * Test for ConstructorDefinition.
 *
 * @package     XJConf
 * @subpackage  test_definitions
 */
class ConstructorDefinitionTestCase extends UnitTestCase
{
    /**
     * instance to test
     *
     * @var  ConstructorDefinition
     */
    protected $constructorDefinition;
    /**
     * a mocked tag
     *
     * @var  Tag
     */
    protected $tag;
    
    /**
     * set up test resources
     */
    public function setUp()
    {
        $this->constructorDefinition = new ConstructorDefinition();
        $this->tag                   = new MockTag();
    }
    
    /**
     * test if construction works
     */
    public function testConstruct()
    {
        $this->assertEqual($this->constructorDefinition->getName(), '__constructor');
        $this->assertNull($this->constructorDefinition->getType());
        $this->assertNull($this->constructorDefinition->getValueType($this->tag));
    }
    
    /**
     * test that the setter method is as expected
     */
    public function testSetterMethod()
    {
        $this->assertNull($this->constructorDefinition->getSetterMethod($this->tag));
    }
    
    /**
     * test that converting the value works as expected
     */
    public function testConvertValue()
    {
        $this->assertNull($this->constructorDefinition->convertValue($this->tag));
    }
    
    /**
     * test that the child related methods always return the same
     */
    public function testChildMethods()
    {
        
        $child1 = new ChildDefinition('child1');
        $child2 = new ChildDefinition('child2');
        $mock   = new MockDefinition();
        $this->assertFalse($this->constructorDefinition->hasChildDefinition('MockDefinition'));
        $this->assertNull($this->constructorDefinition->getChildDefinition('MockDefinition'));
        $this->assertEqual($this->constructorDefinition->getChildDefinitions(), array());
        $this->assertEqual($this->constructorDefinition->getParams(), array());
        $this->assertEqual($this->constructorDefinition->getUsedChildrenNames(), array());
        $this->constructorDefinition->addChildDefinition($mock);
        $this->assertTrue($this->constructorDefinition->hasChildDefinition('MockDefinition'));
        $childDef = $this->constructorDefinition->getChildDefinition('MockDefinition');
        $this->assertReference($childDef, $mock);
        $this->assertEqual($this->constructorDefinition->getChildDefinitions(), array($mock));
        $this->assertEqual($this->constructorDefinition->getParams(), array($mock));
        $this->assertEqual($this->constructorDefinition->getUsedChildrenNames(), array());
        $this->constructorDefinition->addChildDefinition($child1);
        $this->constructorDefinition->addChildDefinition($child2);
        $this->assertTrue($this->constructorDefinition->hasChildDefinition('MockDefinition'));
        $childDef2 = $this->constructorDefinition->getChildDefinition('MockDefinition');
        $this->assertReference($childDef2, $mock);
        $this->assertEqual($this->constructorDefinition->getChildDefinitions(), array($mock, $child1, $child2));
        $this->assertEqual($this->constructorDefinition->getParams(), array($mock, $child1, $child2));
        $this->assertEqual($this->constructorDefinition->getUsedChildrenNames(), array('child1', 'child2'));
        
    }
}
?>