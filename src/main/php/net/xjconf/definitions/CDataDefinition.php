<?php
/**
 * Definition for the character data inside a tag.
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions
 */
namespace net\xjconf\definitions;
use net\xjconf\Tag;
use net\xjconf\converters\factories\ValueConverterFactoryChain;
/**
 * Definition for the character data inside a tag.
 *
 * This is used to pass the character data to the constructor
 * of the tag, while casting it to the desired class.
 *
 * @package     XJConf
 * @subpackage  definitions
 */
class CDataDefinition implements Definition
{
    /**
     * type of the character data
     *
     * @var  string
     */
    private $type           = null;
    /**
     * name of the setter
     *
     * @var  string
     */
    private $setter         = 'setData';
    /**
     * Converter used to convert the character data
     *
     * @var  net\xjconf\converters\ValueConverter
     */
    private $valueConverter;

    /**
     * Create a new CDataDefinition for any other type
     *
     * @param  string  $type  optional  type of the content
     */
    public function __construct($type = null)
    {
        if (null == $type) {
            $type = 'string';
        }

        $this->type = $type;
    }

    /**
     * get the name under which the data will be stored
     *
     * @return  string
     */
    public function getName()
    {
        return 'data';
    }

    /**
     * get the type of the data
     *
     * @return  string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Convert the character data to any type
     *
     * @param   net\xjconf\Tag   $tag
     * @return  mixed            concerted value
     */
    public function convertValue(Tag $tag)
    {
        $instance = $this->getValueConverter()->convertValue($tag, $this);
        return $instance;
    }

    /**
     * Get the type of the cdata
     *
     * @param   net\xjconf\Tag  $tag
     * @return  string
     */
    public function getValueType(Tag $tag) {
        return $this->getValueConverter()->getType();
    }

    /**
     * Set the setter method
     *
     * If no setter method is specified, the standard
     * name "setAttributename()" will be used instead.
     *
     * @param  string  $setter  name of the setter method
     * @see    getSetterMethod()
     */
    public function setSetterMethod($setter)
    {
        $this->setter = $setter;
    }

    /**
     * Get the setter method, which is setData() by default
     *
     * @return  string
     * @see     setSetterMethod()
     */
    public function getSetterMethod(Tag $tag)
    {
        return $this->setter;
    }

    /**
     * Character data cannot have any child definitions
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
     * @param   string   $def
     * @return  net\xjconf\definitions\Definition
     */
    public function getChildDefinition($def)
    {
        return null;
    }

    /**
     * Return all child definitions.
     *
     * Currently it is not possible to add any child
     * definitions to cdata
     *
     * @return  array
     */
    public function getChildDefinitions()
    {
        return array();
    }

    /**
     * Get the value converter for this character data
     *
     * @return  net\xjconf\converters\ValueConverter
     */
    protected function getValueConverter()
    {
        if (null === $this->valueConverter) {
            $this->valueConverter = ValueConverterFactoryChain::getFactory($this)->createValueConverter($this);
        }

        return $this->valueConverter;
    }

    /**
     * This definition does not support named child definitions
     *
     * @param   string                             $name
     * @return  net\xjconf\definitions\Definition
     */
    public function getChildDefinitionByTagName($name) {
        return null;
    }
}
?>