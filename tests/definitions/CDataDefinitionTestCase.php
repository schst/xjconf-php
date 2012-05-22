<?php
/**
 * Test for CDataDefinition.
 *
 * @author  Frank Kleine <mikey@xjconf.net>
 */
Mock::generatePartial('net\xjconf\definitions\CDataDefinition', 'PartialMockCDataDefinition', array('getValueConverter'));
Mock::generate('net\xjconf\Tag', 'MockTag');
Mock::generate('net\xjconf\converters\ValueConverter', 'MockValueConverter');
/**
 * Test for CDataDefinition.
 *
 * @package     XJConf
 * @subpackage  test_definitions
 */
class CDataDefinitionTestCase extends UnitTestCase
{
    /**
     * instance to test
     *
     * @var  CDataDefinition
     */
    protected $cDataDefinition;
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
        $this->cDataDefinition = new PartialMockCDataDefinition();
        $this->tag             = new MockTag();
    }
    
    /**
     * test if construction works
     */
    public function testConstruct()
    {
        $this->cDataDefinition->__construct('int');
        $this->assertEqual($this->cDataDefinition->getName(), 'data');
        $this->assertEqual($this->cDataDefinition->getType(), 'int');
        
        $this->cDataDefinition->__construct('');
        $this->assertEqual($this->cDataDefinition->getName(), 'data');
        $this->assertEqual($this->cDataDefinition->getType(), 'string');
        
        $this->cDataDefinition->__construct();
        $this->assertEqual($this->cDataDefinition->getName(), 'data');
        $this->assertEqual($this->cDataDefinition->getType(), 'string');
    }
    
    /**
     * test that the setter method is as expected
     */
    public function testSetterMethod()
    {
        $this->cDataDefinition->__construct();
        $this->assertEqual($this->cDataDefinition->getSetterMethod($this->tag), 'setData');
        $this->cDataDefinition->setSetterMethod('setFoo');
        $this->assertEqual($this->cDataDefinition->getSetterMethod($this->tag), 'setFoo');
    }
    
    /**
     * test that converting the value works as expected
     */
    public function testConvertValue()
    {
        $this->cDataDefinition->__construct();
        $mockValueConverter = new MockValueConverter();
        $mockValueConverter->setReturnValue('convertValue', 'bar');
        $mockValueConverter->expectCallcount('convertValue', 1);
        $this->cDataDefinition->setReturnValue('getValueConverter', $mockValueConverter);
        $this->assertEqual($this->cDataDefinition->convertValue($this->tag), 'bar');
    }
    
    /**
     * test that the child related methods always return the same
     */
    public function testChildMethods()
    {
        $this->cDataDefinition->__construct();
        $mockDefinition = 'MockDefinition';
        $this->assertFalse($this->cDataDefinition->hasChildDefinition($mockDefinition));
        $this->assertNull($this->cDataDefinition->getChildDefinition($mockDefinition));
        $this->assertEqual($this->cDataDefinition->getChildDefinitions(), array());
    }
}
?>