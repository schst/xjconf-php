<?php
/**
 * Definition to access the child of the tag.
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions
 */
namespace net\xjconf\definitions;
use net\xjconf\Tag;
use net\xjconf\converters\factories\ValueConverterFactoryChain;
use net\xjconf\exceptions\UnsupportedOperationException;
use net\xjconf\exceptions\ValueConversionException;
use net\xjconf\exceptions\XJConfException;
/**
 * Definition to access the child of the tag.
 *
 * This can be used to pass the child to the constructor.
 *
 * @package     XJConf
 * @subpackage  definitions
 */
class MethodCallTagDefinition implements Definition, ValueModifier {

    /**
     * Name of the method to call
     *
     * @var  string
     */
    private $name = null;

    /**
     * Parameters of the method call
     *
     * @var array
     */
    private $params = array();

    /**
     * Create a new child definition
     *
     * @param   string  $name  name of child
     * @throws  net\xjconf\exceptions\XJConfException
     */
    public function __construct($name, $method)
    {
        if (null == $name || strlen($name) == 0) {
            throw new XJConfException('MethodDefinition needs a name.');
        }
        $this->name = $name;
        $this->method = $method;
    }

    /**
     * Get the name of the child.
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * get the type of the child
     *
     * @return  string
     */
    public function getType()
    {
        return null;
    }

    /**
     * Convert the value
     *
     * @param   Tag    $tag
     * @return  mixed  concerted value
     * @throws  net\xjconf\exceptions\UnsupportedOperationException
     */
    public function convertValue(Tag $tag)
    {
        throw new UnsupportedOperationException();
    }

    /**
     * Get the type of the child
     *
     * @param   Tag     $tag
     * @return  string
     * @throws  net\xjconf\exceptions\UnsupportedOperationException
     */
    public function getValueType(Tag $tag)
    {
        throw new UnsupportedOperationException();
    }

    /**
     * This does not provide a setter method.
     *
     * @return  null
     */
    public function getSetterMethod(Tag $tag)
    {
        return null;
    }

    /**
     * It's not possible to add a new child.
     *
     * @param  net\xjconf\definitions\Definition  $def
     */
    public function addChildDefinition(Definition $def)
    {
        $this->params[] = $def;
    }

    /**
     * Checks whether this definition has a specific child condition
     *
     * @param   string   $def
     * @return  boolean  true if definition has a specific child condition, else false
     */
    public function hasChildDefinition($def)
    {
        return false;
    }

    /**
     * Returns the first found definition of type $def
     *
     * @param   string                             $def
     * @return  net\xjconf\definitions\Definition
     */
    public function getChildDefinition($def)
    {
        return null;
    }

    /**
     * Return all child definitions.
     *
     * Currently, it is not possible to add any child
     * definitions to a child
     *
     * @return  array
     */
    public function getChildDefinitions()
    {
        return $this->params;
    }


    /**
     * Call the method on the parent object
     *
     * @param   mixed             $value
     * @param   net\xjconf\Tag    $tag
     * @return  mixed             the modified value
     * @throws  net\xjconf\exceptions\XJConfException
     */
    public function modifyValue($value, Tag $tag)
    {
        if (!is_object($value)) {
            throw new XJConfException('Methods can only be called on objects.');
        }
        $clazz = new \ReflectionClass(get_class($value));
        $method = $clazz->getMethod($this->method);

        $values = array();
        foreach ($this->params as $paramDefinition) {
            $values[] = $paramDefinition->convertValue($tag);
        }
        $method->invokeArgs($value, $values);
    }

    /**
     * This definition does not support named child definitions
     *
     * @param   string                             $name
     * @return  net\xjconf\definitions\Definition
     */
    public function getChildDefinitionByTagName($name)
    {
        return null;
    }
}
?>