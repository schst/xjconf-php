<?php
/**
 * Definition of an XML tag.
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions
 */
namespace net\xjconf\definitions;
use net\xjconf\XJConfClassLoader;
use net\xjconf\DefinedTag;
use net\xjconf\Tag;
use net\xjconf\converters\factories\ValueConverterFactoryChain;
use net\xjconf\exceptions\ValueConversionException;
use net\xjconf\exceptions\XJConfException;
/**
 * Definition of an XML tag.
 *
 * @package     XJConf
 * @subpackage  definitions
 */
abstract class TagDefinition implements Definition
{
    /**
     * the name
     *
     * @var  string
     */
    protected $name           = null;
    /**
     * the name of the tag
     *
     * @var  string
     */
    protected $tagName        = null;
    /**
     * type of the tag
     *
     * @var  string
     */
    protected $type           = null;
    /**
     * list of attribute definitions
     *
     * @var  array<AttributeDefinition>
     */
    protected $atts           = array();
    /**
     * name of the setter
     *
     * @var  string
     */
    protected $setter         = null;
    /**
     * name of attribute that contains the name
     *
     * @var  string
     */
    protected $nameAttribute  = null;
    /**
     * definition of how to construct the object
     *
     * @var  net\xjconf\definitions\ConstructorDefinition
     */
    protected $constructor    = null;
    /**
     * definition of factory that is able to construct the object
     *
     * @var  net\xjconf\definitions\FactoryMethodDefinition
     */
    protected $factoryMethod  = null;
    /**
     * converts the value
     *
     * @var  net\xjconf\converters\ValueConverter
     */
    protected $valueConverter;
    /**
     * Methods to call on this tag
     *
     * @var  array
     */
    protected $methods = array();
    /**
     * list of child definitions
     *
     * @var  array
     */
    protected $childDefs = array();
    /**
     * definition of tag content
     *
     * @var   net\xjconf\definitions\CDataDefinition
     * @todo  Eventually call the setter method for the cdata
     */
    protected $cdata          = null;
    /**
     * the class loader to use
     *
     * @var  net\xjconf\XJConfClassLoader
     */
    protected $classLoader    = null;
    /**
     * list of simple types where the class loader can not be applied to
     *
     * @var  array<string>
     */
    protected $simpleTypes    = array('boolean', 'bool', 'integer', 'int', 'double', 'float', 'string', 'array');
    /**
     * Whether the calls should be made statically or not
     *
     * @var  boolean
     */
    protected $static = false;

    /**
     * set the name of the value
     *
     * @param  string  $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * get the name of the value
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the type of the tag
     *
     * @param  string  $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * get the type of the tag
     *
     * @return  string
     */
    public function getType()
    {
        if (null != $this->classLoader) {
            return $this->classLoader->getType($this->type);
        }

        return $this->type;
    }

    /**
     * Set whether calls should be made statically (true)
     * or an instance of the class should be created (false)
     *
     * @param  boolean  $static
     */
    public function setStatic($static) {
        $this->static = $static;
    }

    /**
     * get the type of the tag
     *
     * @return  string
     */
    public function isStatic()
    {
        return $this->static;
    }

    /**
     * Convert the value of the tag.
     *
     * @param   net\xjconf\Tag  $tag  tag that will be converted
     * @return  mixed           converted value
     * @throws  net\xjconf\exceptions\ValueConversionException
     */
    public function convertValue(Tag $tag)
    {
        // get the data
        $data = $tag->getContent();
        if (null == $data) {
            $data = '';
        }

        // no constructor definition has been set,
        // create a new one
        if (null == $this->constructor && null == $this->factoryMethod) {
            $this->constructor = new ConstructorDefinition();
            $this->constructor->addChildDefinition(new CDataDefinition());
        }

        $instance = $this->getValueConverter()->convertValue($tag, $this);
        return $instance;
    }

    /**
     * Get the type of the tag
     *
     * @return  string
     */
    public function getValueType(Tag $tag)
    {
        return $this->getValueConverter()->getType();
    }

    /**
     * Set the setter method
     *
     * @param  string  $setter  name of the setter method
     */
    public function setSetterMethod($setter)
    {
        $this->setter = $setter;
    }

    /**
     * Get the name of the setter method that should be used
     *
     * @return  string
     */
    public function getSetterMethod(Tag $tag)
    {
        if (null != $this->setter) {
            return $this->setter;
        }

        // no name, the parent should be a collection
        if ('__none' == $this->name) {
            return null;
        }

        return 'set' . ucfirst($this->getKey($tag));
    }

    /**
     * Add a new child definition
     *
     * Possible definitions are:
     * - AttributeDefinition
     * - ConstructorDefinition
     * - FactoryMethodDefinition
     * - CDataDefinition
     *
     * @param  net\xjconf\definitions\Definition  $def
     */
    public function addChildDefinition(Definition $def)
    {
        if ($def instanceof AttributeDefinition) {
            $this->addAttribute($def);
            return;
        }

        if ($def instanceof FactoryMethodDefinition) {
            if ($this->isStatic()) {
                throw new InvalidTagDefinitionException('Static classes may not have a factory method defined.');
            }
            $this->factoryMethod = $def;
            return;
        }

        if ($def instanceof ConstructorDefinition) {
            if ($this->isStatic()) {
                throw new InvalidTagDefinitionException('Static classes may not have a constructor defined.');
            }
            $this->constructor = $def;
            return;
        }

        if ($def instanceof CDataDefinition) {
            $this->cdata = $def;
            return;
        }
        $this->childDefs[] = $def;
    }

    /**
     * Checks whether this definition has a specific child condition
     *
     * @param   string   $def
     * @return  boolean  true if definition has a specific child condition, else false
     */
    public function hasChildDefinition($def)
    {
        $children = $this->getChildDefinitions();
        foreach ($children as $child) {
            if (get_class($child) === $def) {
                return true;
            }
        }

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
        $children = $this->getChildDefinitions();
        foreach ($children as $child) {
            if (get_class($child) === $def) {
                return $child;
            }
        }

        return null;
    }

    /**
     * Return all child definitions.
     *
     * @return  array
     */
    public function getChildDefinitions()
    {
        $children = $this->atts;
        if ($this->factoryMethod instanceof Definition) {
            $children[] = $this->factoryMethod;
        }

        if ($this->constructor instanceof Definition) {
            $children[] = $this->constructor;
        }

        if ($this->cdata instanceof Definition) {
            $children[] = $this->cdata;
        }

        return $children;
    }

    /**
     * Add an attribute to the tag
     *
     * @param  net\xjconf\definitions\AttributeDefinition  $att
     */
    public function addAttribute(AttributeDefinition $att)
    {
        array_push($this->atts, $att);
    }

    /**
     * Return list of attributes for this tag
     *
     * @return  array
     */
    public function getAttributes()
    {
        return $this->atts;
    }

    /**
     * Set the name of the tag
     *
     * @param name
     */
    public function setTagName($name)
    {
        $this->tagName = $name;
    }

    /**
     * Set the attribute that will be used as key.
     *
     * @param  string  $att  name of the key attribute
     */
    public function setKeyAttribute($att)
    {
        $this->name          = '__attribute';
        $this->nameAttribute = $att;
    }

    /**
     * get the name of the tag
     *
     * @return  string
     */
    public function getTagName()
    {
        return $this->tagName;
    }

    /**
     * get the name of the tag
     *
     * @return  string
     */
    public function getKey(DefinedTag $tag)
    {
        if ('__attribute' == $this->name) {
            return $tag->getAttribute($this->nameAttribute);
        }

        return $this->name;
    }

    /**
     * Check, whether the value supports indexed children
     *
     * @return  boolean
     */
    public function supportsIndexedChildren()
    {
        if ($this->getType() == 'array') {
            return true;
        }

        return false;
    }

    /**
     * set the class loader for this tag
     *
     * @param  net\xjconf\XJConfClassLoader  $classLoader
     */
    public function setClassLoader(XJConfClassLoader $classLoader)
    {
        $this->classLoader = $classLoader;
    }

    /**
     * extends itsself from another tag definition
     *
     * @param  net\xjconf\definitions\TagDefinition  $tagDefinition  the tag definition to extend from
     */
    public function extend(self $tagDefinition)
    {
        $this->atts = $tagDefinition->getAttributes();
        $childDefs  = $tagDefinition->getChildDefinitions();
        foreach ($childDefs as $childDef) {
            $this->addChildDefinition($childDef);
        }
        
        $this->setter = $tagDefinition->setter;
    }

    /**
     * Get the methods
     *
     * @return  array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Get the value converter for this tag
     *
     * @return  net\xjconf\converters\ValueConverter
     */
    protected function getValueConverter()
    {
        if (null == $this->type) {
            throw new ValueConversionException('No type set. Can not create ValueConverter.');
        }

        if (null != $this->classLoader && in_array($this->type, $this->simpleTypes) == false) {
            $this->classLoader->loadClass($this->type);
        }

        if (null == $this->valueConverter) {
            $this->valueConverter = ValueConverterFactoryChain::getFactory($this)->createValueConverter($this);
        }

        return $this->valueConverter;
    }

    /**
     * returns child definition with given name
     *
     * @param   string                             $name
     * @return  net\xjconf\definitions\Definition
     */
    public function getChildDefinitionByTagName($name)
    {
        foreach ($this->childDefs as $childDef) {
            if ($childDef->getName() == $name) {
                return $childDef;
            }
        }
        
        return null;
    }
}
?>