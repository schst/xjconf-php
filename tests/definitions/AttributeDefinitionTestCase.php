<?php
/**
 * Test for AttributeDefinition.
 *
 * @author  Frank Kleine <mikey@xjconf.net>
 */
Mock::generatePartial('net\xjconf\definitions\AttributeDefinition', 'PartialMockAttributeDefinition', array('getValueConverter'));
Mock::generate('net\xjconf\Tag', 'MockTag');
Mock::generate('net\xjconf\converters\ValueConverter', 'MockValueConverter');
/**
 * Test for AttributeDefinition.
 *
 * @package     XJConf
 * @subpackage  test_definitions
 */
class AttributeDefinitionTestCase extends UnitTestCase
{
    /**
     * instance to test
     *
     * @var  AttributeDefinition
     */
    protected $attributeDefinition;
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
        $this->attributeDefinition = new PartialMockAttributeDefinition();
        $this->tag                 = new MockTag();
    }
    
    /**
     * test if construction works
     */
    public function testConstruct()
    {
        $this->attributeDefinition->__construct('test');
        $this->assertEqual($this->attributeDefinition->getName(), 'test');
        $this->assertEqual($this->attributeDefinition->getType(), 'string');
        
        $this->attributeDefinition->__construct('test', 'int');
        $this->assertEqual($this->attributeDefinition->getName(), 'test');
        $this->assertEqual($this->attributeDefinition->getType(), 'int');
        
        $this->expectException('net\xjconf\exceptions\InvalidTagDefinitionException');
        $this->attributeDefinition->__construct('');
    }
    
    /**
     * test that the setter method is as expected
     */
    public function testSetterMethod()
    {
        $this->attributeDefinition->__construct('test');
        $this->assertEqual($this->attributeDefinition->getSetterMethod($this->tag), 'setTest');
        $this->attributeDefinition->setSetterMethod('setFoo');
        $this->assertEqual($this->attributeDefinition->getSetterMethod($this->tag), 'setFoo');
    }
    
    /**
     * test that converting the value works as expected
     */
    public function testConvertValue()
    {
        $this->tag->setReturnValue('hasAttribute', false);
        $this->tag->setReturnValueAt(2, 'hasAttribute', true);
        $this->tag->setReturnValue('getAttribute', null);
        
        $this->attributeDefinition->__construct('test');
        $this->assertNull($this->attributeDefinition->convertValue($this->tag));
        
        $this->attributeDefinition->setDefault('foo');
        $mockValueConverter = new MockValueConverter();
        $mockValueConverter->setReturnValue('convertValue', 'bar');
        $mockValueConverter->expectCallcount('convertValue', 1);
        $this->attributeDefinition->setReturnValue('getValueConverter', $mockValueConverter);
        $this->assertEqual($this->attributeDefinition->convertValue($this->tag), 'bar');
        
        $this->attributeDefinition->setRequired(true);
        $this->expectException('net\xjconf\exceptions\MissingAttributeException');
        $this->attributeDefinition->convertValue($this->tag);
    }
}
?>