<?php
/**
 * Definition container of an attribute.
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions
 */
namespace net\xjconf\definitions;
use net\xjconf\GenericTag;
use net\xjconf\Tag;
use net\xjconf\converters\factories\ValueConverterFactoryChain;
use net\xjconf\exceptions\InvalidTagDefinitionException;
use net\xjconf\exceptions\MissingAttributeException;
use net\xjconf\exceptions\ValueConversionException;
use net\xjconf\exceptions\XJConfException;
/**
 * Definition container of an attribute.
 *
 * This class is used to store information on how
 * an attribute of a specific tag should be handled.
 *
 * Options include
 * - Type of the Attribute
 * - Default value for non-existent attributes
 * - Setter method to set the attribute
 * - Whether the attribute is required, or not
 *
 * @package     XJConf
 * @subpackage  definitions
 */
class AttributeDefinition implements Definition
{
    /**
     * name of the attribute
     *
     * @var  string
     */
    private $name         = null;
    /**
     * Type of the attribute
     *
     * @var  string
     */
    private $type         = null;
    /**
     * Name of the setter method
     *
     * @var  string
     */
    private $setter       = null;
    /**
     * Default value
     *
     * @var  string
     */
    private $defaultValue = null;
    /**
     * Whether the attribute is required
     *
     * @var  boolean
     */
    private $required     = false;
    /**
     * Converter used to convert the attribute
     *
     * @param  net\xjconf\converter\ValueConverter
     */
    private $valueConverter;

    /**
     * create a new attribute definition for a String attribute
     *
     * @param   string  $name  name of the attribute
     * @param   string  $type  optional  type of the tag
     * @throws  net\xjconf\exceptions\XJConfException
     */
    public function __construct($name, $type = null)
    {
        if (null == $name || strlen($name) == 0) {
            throw new InvalidTagDefinitionException('AttributeDefinition needs a name.');
        }

        $this->name = $name;
        if (null == $type || strlen($type) == 0) {
            $this->type = 'string';
        } else {
            $this->type = $type;
        }
    }

    /**
     * Get the name of the attribute.
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the type of the attribute
     *
     * @return  string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Convert a value to the defined type
     *
     * The value you pass in will be cast to a
     * String before it is converted to the defined
     * type.
     *
     * The type of the returned value can be specified in
     * the constructor using the type argument.
     *
     * @param   net\xjconf\Tag    $tag
     * @return  mixed  concerted value
     * @throws  net\xjconf\exceptions\ValueConversionException
     * @throws  net\xjconf\exceptions\MissingAttributeException
     */
    public function convertValue(Tag $tag)
    {
        if ($tag->hasAttribute($this->getName())) {
            $value = $tag->getAttribute($this->getName());
        } else {
            $value = $this->getDefault();
        }



        if (null === $value) {
            if ($this->isRequired() == true) {
                throw new MissingAttributeException('The attribute "' . $this->getName() . '" is required for the tag "' . $tag->getName() . '".');
            }

            // it's useless to create an instance passing null to the constructor.
            return null;
        }

        $tag = new GenericTag($this->getName(), array());
        $tag->addData($value);

        $instance = $this->getValueConverter()->convertValue($tag, $this);
        return $instance;
    }

    /**
     * Get the type of the attribute
     *
     * @param   net\xjconf\Tag     $tag
     * @return  string
     */
    public function getValueType(Tag $tag)
    {
        return $this->valueConverter->getType();
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
     * Get the name of the setter method that should be used
     * to set the attribute value in the parent container
     *
     * @return  string
     * @see     setSetterMethod()
     */
    public function getSetterMethod(Tag $tag)
    {
        if (null == $this->setter) {
            return 'set' . ucfirst($this->getName());
        }

        return $this->setter;
    }

    /**
     * Add a child definition
     *
     * Attributes can not have any children.
     *
     * @param  net\xjconf\definitions\Definition  $def
     */
    public function addChildDefinition(Definition $def)
    {
        // attributes can not have any children.
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
     * Currently, it is not possible to add any child
     * definitions to an attribute
     *
     * @return  array
     */
    public function getChildDefinitions()
    {
        return array();
    }

    /**
     * Set the default value for the attribute.
     *
     * @param  string  $defaultValue  default value that will be used, if a tag does not provide the attribute
     * @see    getDefault()
     */
    public function setDefault($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * Get the default value of the attribute.
     *
     * @return  string
     * @see     setDefault()
     */
    public function getDefault()
    {
        return $this->defaultValue;
    }

    /**
     * returns whether the attribute is required or not
     *
     * @return  boolean
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * set if attribute is required
     *
     * @param  boolean  $required
     */
    public function setRequired($required)
    {
        $this->required = $required;
    }

    /**
     * Get the value converter for this tag
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
    public function getChildDefinitionByTagName($name)
    {
        return null;
    }
}
?>