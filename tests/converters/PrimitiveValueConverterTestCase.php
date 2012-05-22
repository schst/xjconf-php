<?php
/**
 * Test for PrimitiveValueConverter.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  test_converters
 */
use net\xjconf\converters\PrimitiveValueConverter;
Mock::generate('net\xjconf\Tag', 'MockTag');
Mock::generate('net\xjconf\definitions\Definition', 'MockDefinition');
/**
 * Test for PrimitiveValueConverter.
 *
 * @package     XJConf
 * @subpackage  test_converters
 */
class PrimitiveValueConverterTestCase extends UnitTestCase
{
    /**
     * a mocked definition
     *
     * @var  SimpleMock
     */
    protected $definition;
    /**
     * a mocked tag
     *
     * @var  SimpleMock
     */
    protected $tag;
    
    /**
     * set up test resources
     */
    public function setUp()
    {
        $this->tag        = new MockTag();
        $this->definition = new MockDefinition();
    }

    /**
     * test if converting to boolean works
     */
    public function testBoolean()
    {
        $converter = new PrimitiveValueConverter('boolean');
        $this->assertEqual($converter->getType(), 'boolean');
        $this->tag->setReturnValueAt(0, 'getData', 'false');
        $this->assertFalse($converter->convertValue($this->tag, $this->definition));
        $this->tag->setReturnValueAt(1, 'getData', 0);
        $this->assertFalse($converter->convertValue($this->tag, $this->definition));
        $this->tag->setReturnValueAt(2, 'getData', '0');
        $this->assertFalse($converter->convertValue($this->tag, $this->definition));
        $this->tag->setReturnValueAt(3, 'getData', 'true');
        $this->assertTrue($converter->convertValue($this->tag, $this->definition));
        $this->tag->setReturnValueAt(4, 'getData', 1);
        $this->assertTrue($converter->convertValue($this->tag, $this->definition));
        $this->tag->setReturnValueAt(5, 'getData', '1');
        $this->assertTrue($converter->convertValue($this->tag, $this->definition));
        $this->tag->setReturnValueAt(6, 'getData', null);
        $this->assertFalse($converter->convertValue($this->tag, $this->definition));
    }

    /**
     * test if converting to boolean works
     */
    public function testBool()
    {
        $converter = new PrimitiveValueConverter('bool');
        $this->assertEqual($converter->getType(), 'bool');
        $this->tag->setReturnValueAt(0, 'getData', 'false');
        $this->assertFalse($converter->convertValue($this->tag, $this->definition));
        $this->tag->setReturnValueAt(1, 'getData', 0);
        $this->assertFalse($converter->convertValue($this->tag, $this->definition));
        $this->tag->setReturnValueAt(2, 'getData', '0');
        $this->assertFalse($converter->convertValue($this->tag, $this->definition));
        $this->tag->setReturnValueAt(3, 'getData', 'true');
        $this->assertTrue($converter->convertValue($this->tag, $this->definition));
        $this->tag->setReturnValueAt(4, 'getData', 1);
        $this->assertTrue($converter->convertValue($this->tag, $this->definition));
        $this->tag->setReturnValueAt(5, 'getData', '1');
        $this->assertTrue($converter->convertValue($this->tag, $this->definition));
        $this->tag->setReturnValueAt(6, 'getData', null);
        $this->assertFalse($converter->convertValue($this->tag, $this->definition));
    }

    /**
     * test if converting to integer works
     */
    public function testInteger()
    {
        $converter = new PrimitiveValueConverter('integer');
        $this->assertEqual($converter->getType(), 'integer');
        $this->tag->setReturnValueAt(0, 'getData', 'false');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0);
        $this->tag->setReturnValueAt(1, 'getData', 0);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0);
        $this->tag->setReturnValueAt(2, 'getData', '0');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0);
        $this->tag->setReturnValueAt(3, 'getData', 'true');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0);
        $this->tag->setReturnValueAt(4, 'getData', 1);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 1);
        $this->tag->setReturnValueAt(5, 'getData', '1');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 1);
        $this->tag->setReturnValueAt(6, 'getData', 2.6);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 2);
        $this->tag->setReturnValueAt(7, 'getData', '2.7');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 2);
        $this->tag->setReturnValueAt(8, 'getData', null);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0);
    }

    /**
     * test if converting to integer works
     */
    public function testInt()
    {
        $converter = new PrimitiveValueConverter('int');
        $this->assertEqual($converter->getType(), 'int');
        $this->tag->setReturnValueAt(0, 'getData', 'false');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0);
        $this->tag->setReturnValueAt(1, 'getData', 0);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0);
        $this->tag->setReturnValueAt(2, 'getData', '0');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0);
        $this->tag->setReturnValueAt(3, 'getData', 'true');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0);
        $this->tag->setReturnValueAt(4, 'getData', 1);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 1);
        $this->tag->setReturnValueAt(5, 'getData', '1');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 1);
        $this->tag->setReturnValueAt(6, 'getData', 2.6);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 2);
        $this->tag->setReturnValueAt(7, 'getData', '2.7');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 2);
        $this->tag->setReturnValueAt(8, 'getData', null);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0);
    }

    /**
     * test if converting to double works
     */
    public function testDouble()
    {
        $converter = new PrimitiveValueConverter('double');
        $this->assertEqual($converter->getType(), 'double');
        $this->tag->setReturnValueAt(0, 'getData', 'false');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0.0);
        $this->tag->setReturnValueAt(1, 'getData', 0);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0.0);
        $this->tag->setReturnValueAt(2, 'getData', '0');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0.0);
        $this->tag->setReturnValueAt(3, 'getData', 'true');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0.0);
        $this->tag->setReturnValueAt(4, 'getData', 1);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 1.0);
        $this->tag->setReturnValueAt(5, 'getData', '1');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 1.0);
        $this->tag->setReturnValueAt(6, 'getData', 2.6);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 2.6);
        $this->tag->setReturnValueAt(7, 'getData', '2.7');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 2.7);
        $this->tag->setReturnValueAt(8, 'getData', null);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0.0);
    }

    /**
     * test if converting to float works
     */
    public function testFloat()
    {
        $converter = new PrimitiveValueConverter('float');
        $this->assertEqual($converter->getType(), 'float');
        $this->tag->setReturnValueAt(0, 'getData', 'false');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0.0);
        $this->tag->setReturnValueAt(1, 'getData', 0);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0.0);
        $this->tag->setReturnValueAt(2, 'getData', '0');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0.0);
        $this->tag->setReturnValueAt(3, 'getData', 'true');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0.0);
        $this->tag->setReturnValueAt(4, 'getData', 1);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 1.0);
        $this->tag->setReturnValueAt(5, 'getData', '1');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 1.0);
        $this->tag->setReturnValueAt(6, 'getData', 2.6);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 2.6);
        $this->tag->setReturnValueAt(7, 'getData', '2.7');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 2.7);
        $this->tag->setReturnValueAt(8, 'getData', null);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 0.0);
    }

    /**
     * test if converting to string works
     */
    public function testString()
    {
        $converter = new PrimitiveValueConverter('string');
        $this->assertEqual($converter->getType(), 'string');
        $this->tag->setReturnValueAt(0, 'getData', 'false');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), 'false');
        $this->tag->setReturnValueAt(1, 'getData', 0);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), '0');
        $this->tag->setReturnValueAt(2, 'getData', '0');
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), '0');
        $this->tag->setReturnValueAt(3, 'getData', true);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), '1');
        $this->tag->setReturnValueAt(4, 'getData', false);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), '');
        $this->tag->setReturnValueAt(5, 'getData', 1);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), '1');
        $this->tag->setReturnValueAt(6, 'getData', 2.6);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), '2.6');
        $this->tag->setReturnValueAt(7, 'getData', null);
        $this->assertEqual($converter->convertValue($this->tag, $this->definition), '');
    }

    /**
     * assert that any other value and type converts to null
     */
    public function testOther()
    {
        $converter = new PrimitiveValueConverter('stdClass');
        $this->assertNull($converter->getType());
        $this->tag->setReturnValueAt(0, 'getData', 'false');
        $this->assertNull($converter->convertValue($this->tag, $this->definition));
    }
}
?>