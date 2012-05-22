<?php
/**
 * Definition for factory methods.
 *
 * @author      Stephan Schmidt <me@schst.net>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions
 */
namespace net\xjconf\definitions;
use net\xjconf\Tag;
use net\xjconf\exceptions\UnsupportedOperationException;
/**
 * Definition for factory methods.
 *
 * Stores information about a factory method that is used to create an instance.
 *
 * @package     XJConf
 * @subpackage  definitions
 */
class FactoryMethodDefinition implements Definition
{
    /**
     * Parameters of the factory method
     *
     * @var  array
     */
    private $params = array();
    /**
     * name of factory method
     *
     * @var  string
     */
    private $name   = '';

    /**
     * construcor
     *
     * @param  string  $name  name of factory method
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the name under which it will be stored
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * get the type of the factory method
     *
     * @return  string
     */
    public function getType()
    {
        return null;
    }

    /**
     * Convert the factory method.
     *
     * @param   net\xjconf\Tag  $tag
     * @throws  net\xjconf\exceptions\UnsupportedOperationException
     */
    public function convertValue(Tag $tag)
    {
        throw new UnsupportedOperationException();
    }

    /**
     * Get the type of the factory method.
     *
     * @param   net\xjconf\Tag  $tag
     * @throws  net\xjconf\exceptions\UnsupportedOperationException
     */
    public function getValueType(Tag $tag)
    {
        throw new UnsupportedOperationException();
    }

    /**
     * Get the setter method
     *
     * @throws  net\xjconf\exceptions\UnsupportedOperationException
     */
    public function getSetterMethod(Tag $tag)
    {
        throw new UnsupportedOperationException();
    }

    /**
     * Add a new child definition (equals a parameter of the factory method)
     *
     *  @param  net\xjconf\definitions\Definition  $def
     */
    public function addChildDefinition(Definition $def)
    {
        array_push($this->params, $def);
    }

    /**
     * Checks whether this definition has a specific child condition
     *
     * @param   string   $def
     * @return  boolean  true if definition has a specific child condition, else false
     */
    public function hasChildDefinition($def)
    {
        foreach ($this->params as $param) {
            if (get_class($param) === $def) {
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
        foreach ($this->params as $param) {
            if (get_class($param) === $def) {
                return $param;
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
        return $this->params;
    }

    /**
     * Get the names of all child elements that are used in
     * the constructor.
     *
     * These children are not used, when adding them using
     * setter-methods.
     *
     * @return  array
     */
    public function getUsedChildrenNames()
    {
        $childrenNames = array();
        foreach ($this->params as $param) {
            if ($param instanceof ChildDefinition) {
                array_push($childrenNames, $param->getName());
            }
        }

        return $childrenNames;
    }

    /**
     * Get the parameters of the factory method
     *
     * @return  array
     */
    public function getParams()
    {
        return $this->params;
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