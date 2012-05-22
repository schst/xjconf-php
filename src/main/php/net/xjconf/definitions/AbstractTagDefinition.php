<?php
/**
 * Definition of an abstract XML tag.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions
 */
namespace net\xjconf\definitions;
use net\xjconf\Tag;
use net\xjconf\exceptions\InvalidTagDefinitionException;
use net\xjconf\exceptions\ValueConversionException;
/**
 * Definition of an abstract XML tag.
 *
 * @package     XJConf
 * @subpackage  definitions
 */
class AbstractTagDefinition extends TagDefinition
{
    /**
     * abstract type of the tag
     *
     * @var  string
     */
    private $abstractType          = null;
    /**
     * attribute that contains the concrete type name
     *
     * @var  string
     */
    private $concreteTypeAttribute = null;

    /**
     * Create a new tag definition
     *
     * @param   string  $name                   name of the tag
     * @param   string  $abstractType           type of the tag
     * @param   string  $concreteTypeAttribute  attribute name containing the concrete type
     * @throws  net\xjconf\exceptions\InvalidTagDefinitionException
     */
    public function __construct($name, $abstractType, $concreteTypeAttribute)
    {
        if (null == $name || strlen($name) === 0) {
            throw new InvalidTagDefinitionException('AbstractTagDefinition needs a name.');
        }
        if (null == $abstractType || strlen($abstractType) === 0) {
            throw new InvalidTagDefinitionException('AbstractTagDefinition needs an abstract type.');
        }
        if (null == $concreteTypeAttribute || strlen($concreteTypeAttribute) === 0) {
            throw new InvalidTagDefinitionException('AbstractTagDefinition needs a concrete type attribute name.');
        }

        $this->name                  = $name;
        $this->tagName               = $name;
        $this->abstractType          = $abstractType;
        $this->concreteTypeAttribute = $concreteTypeAttribute;
    }
    
    /**
     * returns the name of the attribute which contains the concrete type
     *
     * @return  string
     */
    public function getConcreteTypeAttributeName()
    {
        return $this->concreteTypeAttribute;
    }

    /**
     * get the type of the tag
     *
     * @return  string
     */
    public function getType()
    {
        if (null != $this->type) {
            if (null != $this->classLoader && in_array($this->type, $this->simpleTypes) === false) {
                return $this->classLoader->getType($this->type);
            }
            
            return $this->type;
        }
        
        if (null != $this->classLoader && in_array($this->abstractType, $this->simpleTypes) === false) {
            return $this->classLoader->getType($this->abstractType);
        }
        
        return $this->abstractType;
    }

    /**
     * Convert the value of the tag.
     *
     * @param   net\xjconf\Tag    $tag  tag that will be converted
     * @return  mixed  converted value
     * @throws  net\xjconf\exceptions\ValueConversionException
     */
    public function convertValue(Tag $tag)
    {
        $instance = parent::convertValue($tag);
        if (is_subclass_of($instance, $this->abstractType) === true) {
            return $instance;
        }
        
        $refClass = new \ReflectionClass(get_class($instance));
        if (null != $this->classLoader && in_array($this->abstractType, $this->simpleTypes) === false) {
            $abstractType = $this->classLoader->getType($this->abstractType);
        } else {
            $abstractType = $this->abstractType;
        }
        
        if (in_array($abstractType, array_keys($refClass->getInterfaces())) === true) {
            return $instance;
        }
        
        throw new ValueConversionException('Created instance is not an instance of ' . $this->abstractType);
    }
}
?>