<?php
/**
 * Definition for the constructor of a class
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions
 */
namespace net\xjconf\definitions;
use net\xjconf\Tag;
/**
 * Definition for the constructor of a class
 *
 * @package     XJConf
 * @subpackage  definitions
 */
class ConstructorDefinition implements Definition
{
    /**
     * Parameters of the constructor
     *
     * @var  array<net\xjconf\definitions\Definition>
     */
    private $params = array();

    /**
    * Get the name under which it will be stored
    *
    * @return  string
    */
    public function getName()
    {
        return '__constructor';
    }

    /**
     * get the type of the constructor
     *
     * @return  string
     */
    public function getType()
    {
        return null;
    }

    /**
     * Convert the constructor.
     *
     * This does not do anything!
     *
     * @param   net\xjconf\Tag  $tag
     * @return  null
     */
    public function convertValue(Tag $tag)
    {
        return null;
    }

    /**
     * Get the type of the constructor
     *
     * @param   net\xjconf\Tag  $tag
     * @return  null
     */
    public function getValueType(Tag $tag)
    {
        return null;
    }

    /**
     * Get the setter method
     *
     * @return  null
     */
    public function getSetterMethod(Tag $tag)
    {
        return null;
    }

    /**
     * Add a new child definition (equals a parameter of the constructor)
     *
     * @param  net\xjconf\definitions\Definition  $def
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
     * Get the parameters of the constructor
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
    public function getChildDefinitionByTagName($name) {
        return null;
    }
}
?>