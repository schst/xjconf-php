<?php
/**
 * Interface for tag and attribute definitions.
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions
 */
namespace net\xjconf\definitions;
use net\xjconf\Tag;
/**
 * Interface for tag and attribute definitions.
 *
 * @package     XJConf
 * @subpackage  definitions
 */
interface Definition
{
    /**
     * Get the name under which the information
     * will be stored.
     *
     * @return  string  name of the value
     */
    public function getName();

    /**
     * Get the type of the definition
     *
     * @return  string
     */
    public function getType();

    /**
     * Get the converted value.
     *
     * XJConf will pass the complete tag to this method
     *
     * @param   net\xjconf\Tag  $tag  value
     * @return  mixed
     */
    public function convertValue(Tag $tag);

    /**
     * Get the type of the converted value
     * @param   net\xjconf\Tag  $tag  value
     * @return  string
     */
    public function getValueType(Tag $tag);

    /**
     * Get the name of the setter method
     *
     * @return  string
     */
    public function getSetterMethod(Tag $tag);

    /**
     * Add a child definition of any type
     *
     * @param  net\xjconf\definitions\Definition  $def
     */
    public function addChildDefinition(Definition $def);

    /**
     * Checks whether this definition has a specific child condition
     *
     * @param   string   $def
     * @return  boolean  true if definition has a specific child condition, else false
     */
    public function hasChildDefinition($def);

    /**
     * Returns the first found definition of type $def
     *
     * @param   string                             $def
     * @return  net\xjconf\definitions\Definition
     */
    public function getChildDefinition($def);

    /**
     * Get all child definitions of the definition
     *
     * @return  array
     */
    public function getChildDefinitions();

    /**
     * returns child definition with given name
     *
     * @param   string                             $name
     * @return  net\xjconf\definitions\Definition
     */
    public function getChildDefinitionByTagName($name);
}
?>