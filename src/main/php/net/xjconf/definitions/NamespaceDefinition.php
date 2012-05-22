<?php
/**
 * Container for all tag definitions in one namespace.
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions
 */
namespace net\xjconf\definitions;
/**
 * Container for all tag definitions in one namespace.
 *
 * @package     XJConf
 * @subpackage  definitions
 */
class NamespaceDefinition
{
    /**
     * list of tag definitions
     * 
     * @var  array<String,TagDefinition>
     */
    private $tagDefinitions = array();
    /**
     * URI of this namespace
     * 
     * @var  string
     */
    private $namespaceURI   = null;

    /**    
     * Constructor for a namespace definition
     * 
     * @param  string  namespaceURI  URI of the new namespace
     */
    public function __construct($namespaceURI)
    {
        $this->namespaceURI = $namespaceURI;
    }

    /**
     * Add a new tag definition
     * 
     * @param  net\xjconf\definitions\TagDefinition  $tagDefinition
     */
    public function addTagDefinition(TagDefinition $tagDefinition)
    {
        $this->tagDefinitions[$tagDefinition->getTagName()] = $tagDefinition;
    }

    /**
     * Count the number of defined tags
     * 
     * @return  int  number of defined tags
     */
    public function countTagDefinitions()
    {
        return count($this->tagDefinitions);
    }

    /**
     * Check, whether a tag has been defined
     * 
     * @param   string   $tagName  name of the tag
     * @return  boolean  true, if the tag has been defined, false otherwise
     */
    public function isDefined($tagName)
    {
        return isset($this->tagDefinitions[$tagName]);
    }

    /**
     * Get the definition of a tag
     * 
     * @param   string                                $tagName name of the tag
     * @return  net\xjconf\definitions\TagDefinition
     */
    public function getDefinition($tagName)
    {
        if ($this->isDefined($tagName) == true) {
            return $this->tagDefinitions[$tagName];
        }
        
        return null;
    }

    /**
     * Get the URI for this namespace
     * 
     * @return  string
     */
    public function getNamespaceURI()
    {
        return $this->namespaceURI;
    }
}
?>