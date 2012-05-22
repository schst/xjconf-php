<?php
/**
 * Test for FactoryMethodDefinition.
 *
 * @author  Frank Kleine <mikey@xjconf.net>
 */
use net\xjconf\definitions\ChildDefinition;
use net\xjconf\definitions\FactoryMethodDefinition;
Mock::generate('net\xjconf\Tag', 'MockTag');
Mock::generate('net\xjconf\definitions\Definition', 'MockDefinition');
/**
 * Test for FactoryMethodDefinition.
 *
 * @package     XJConf
 * @subpackage  test_definitions
 */
class FactoryMethodDefinitionTestCase extends UnitTestCase
{
    /**
     * instance to test
     *
     * @var  FactoryMethod
     */
    protected $factoryMethodDefinition;
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
        $this->factoryMethodDefinition = new FactoryMethodDefinition('test');
        $this->tag                     = new MockTag();
    }
    
    /**
     * test if construction works
     */
    public function testConstruct()
    {
        $this->assertEqual($this->factoryMethodDefinition->getName(), 'test');
        $this->assertNull($this->factoryMethodDefinition->getType());
    }
    
    /**
     * test that the setter method is as expected
     */
    public function testSetterMethod()
    {
        $this->expectException('net\xjconf\exceptions\UnsupportedOperationException');
        $this->factoryMethodDefinition->getSetterMethod($this->tag);
    }
    
    /**
     * test that converting the value works as expected
     */
    public function testConvertValue()
    {
        $this->expectException('net\xjconf\exceptions\UnsupportedOperationException');
        $this->factoryMethodDefinition->convertValue($this->tag);
    }
    
    /**
     * test that the child related methods always return the same
     */
    public function testChildMethods()
    {
        $child1 = new ChildDefinition('child1');
        $child2 = new ChildDefinition('child2');
        $mock   = new MockDefinition();
        $this->assertFalse($this->factoryMethodDefinition->hasChildDefinition('MockDefinition'));
        $this->assertNull($this->factoryMethodDefinition->getChildDefinition('MockDefinition'));
        $this->assertEqual($this->factoryMethodDefinition->getChildDefinitions(), array());
        $this->assertEqual($this->factoryMethodDefinition->getParams(), array());
        $this->assertEqual($this->factoryMethodDefinition->getUsedChildrenNames(), array());
        $this->factoryMethodDefinition->addChildDefinition($mock);
        $this->assertTrue($this->factoryMethodDefinition->hasChildDefinition('MockDefinition'));
        $childDef = $this->factoryMethodDefinition->getChildDefinition('MockDefinition');
        $this->assertReference($childDef, $mock);
        $this->assertEqual($this->factoryMethodDefinition->getChildDefinitions(), array($mock));
        $this->assertEqual($this->factoryMethodDefinition->getParams(), array($mock));
        $this->assertEqual($this->factoryMethodDefinition->getUsedChildrenNames(), array());
        $this->factoryMethodDefinition->addChildDefinition($child1);
        $this->factoryMethodDefinition->addChildDefinition($child2);
        $this->assertTrue($this->factoryMethodDefinition->hasChildDefinition('MockDefinition'));
        $childDef2 = $this->factoryMethodDefinition->getChildDefinition('MockDefinition');
        $this->assertReference($childDef2, $mock);
        $this->assertEqual($this->factoryMethodDefinition->getChildDefinitions(), array($mock, $child1, $child2));
        $this->assertEqual($this->factoryMethodDefinition->getParams(), array($mock, $child1, $child2));
        $this->assertEqual($this->factoryMethodDefinition->getUsedChildrenNames(), array('child1', 'child2'));
    }
}
?>