<?php
/**
 * Stores definitions of several namespaces.
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions
 */
namespace net\xjconf\definitions;
/**
 * Stores definitions of several namespaces.
 *
 * @package     XJConf
 * @subpackage  definitions
 */
class NamespaceDefinitions
{
    /**
     * list of namespace definitions
     * 
     * @var  array<String,net\xjconf\definitions\NamespaceDefinition>
     */
    private $namespaces = array();
    
    /**
     * Add the definition for a namespace
     * 
     * @param  string                                      $namespace  namespace URI  
     * @param  net\xjconf\definitions\NamespaceDefinition  $def        namespace definition object
     */
    public function addNamespaceDefinition($namespace, NamespaceDefinition $def)
    {
        $this->namespaces[$namespace] = $def;
    }

    /**
     * Get a namespace defintition.
     * 
     * @param   string                                      $namespace  namespace URI  
     * @return  net\xjconf\definitions\NamespaceDefinition 
     */
    public function getNamespaceDefinition($namespace)
    {
        if ($this->isNamespaceDefined($namespace) == true) {
            return $this->namespaces[$namespace];
        }
        
        return null;
    }
    
    /**    
     * Check, whether a namespace has been defined
     * 
     * @param   string  $namespace  namespace URI
     * @return  bool    true, if the namespace has been defined, false otherwise
     */
    public function isNamespaceDefined($namespace)
    {
        return isset($this->namespaces[$namespace]);
    }

    /**
     * Get the defined namespaces.
     * 
     * @return  array  list of all namespace URIs that have been defined
     */
     public function getDefinedNamespaces()
     {
         return $this->namespaces;
     }
    
    /**
     * Check, whether a tag has been defined
     * 
     * @param   string   $namespace  namespace URI
     * @param   string   $tagName    local tag name
     * @return  boolean  true, if the tag has been defined, false otherwise
     */
    public function isTagDefined($namespace, $tagName)
    {
        if ($this->isNamespaceDefined($namespace) == false) {
            return false;
        }
        
        return $this->getNamespaceDefinition($namespace)->isDefined($tagName);
    }
    
    /**
     * Get the definition of a single tag
     * 
     * @param   string         $namespace  namespace URI
     * @param   string         $tagName    local tag name
     * @return  net\xjconf\definitions\TagDefinition
     */
    public function getTagDefinition($namespace, $tagName)
    {
        if ($this->isNamespaceDefined($namespace) == false) {
            return null;
        }
        
        return $this->getNamespaceDefinition($namespace)->getDefinition($tagName);
    }

   /**
    * Get the total amount of defined tags in all namespaces
    * 
    * @return  int  total amount of defined tags
    */
    public function countTagDefinitions()
    {
        $amount = 0;
        foreach ($this->namespaces as $namespace) {
            $amount += $namespace->countTagDefinitions();
        }
        
        return $amount;
    }
    
    /**
     * Append more namespace definitions to the current
     * definitions. Can be used if namespace definitions are read from
     * more than one file.
     * 
     * @param  net\xjconf\definitions\NamespaceDefinitions  $nsDefs
     */
    public function appendNamespaceDefinitions(NamespaceDefinitions $nsDefs)
    {
        foreach ($nsDefs->getDefinedNamespaces() as $namespace => $nsDef) {
             $this->addNamespaceDefinition($namespace, $nsDef);
        }
    }
}
?>