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
class ChildDefinition implements Definition
{
    /**
     * Name of the child to access
     *
     * @var  string
     */
    private $name = null;

    /**
     * Create a new child definition
     *
     * @param   string  $name  name of child
     * @throws  net\xjconf\exceptions\XJConfException
     */
    public function __construct($name)
    {
        if (null == $name || strlen($name) == 0) {
            throw new XJConfException('ChildDefinition needs a name.');
        }

        $this->name = $name;
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
     * @throws  net\xjconf\exceptions\ValueConversionException
     */
    public function convertValue(Tag $tag)
    {
        $child = $tag->getChild($this->getName());
        if (null == $child) {
            throw new ValueConversionException('Child element "' . $this->getName() . '" does not exist.');
        }

        return $child->getConvertedValue();
    }

    /**
     * Get the type of the child
     *
     * @param   Tag     $tag
     * @return  string
     * @throws  net\xjconf\exceptions\ValueConversionException
     */
    public function getValueType(Tag $tag)
    {
        $child = $tag->getChild($this->getName());
        if (null == $child) {
            throw new ValueConversionException('Child element "' . $this->getName() . '" does not exist.');
        }

        return $child->getValueType($tag);
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
        // Character data can not have any children.
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
        return array();
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