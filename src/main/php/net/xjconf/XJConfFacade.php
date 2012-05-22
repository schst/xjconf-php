<?php
/**
 * Facade for XJConf.
 *
 * @author   Frank Kleine <mikey@xjconf.net>
 * @package  XJConf
 */
namespace net\xjconf;
use net\xjconf\definitions\NamespaceDefinitions;
use net\xjconf\ext\Extension;
/**
 * Facade for XJConf.
 *
 * @package  XJConf
 */
class XJConfFacade
{
    /**
     * list of class loaders to use
     *
     * @var  array<string,net\xjconf\XJConfClassLoader>
     */
    protected $classLoaders         = array();
    /**
     * list of extensions to use
     *
     * @var  array<string,net\xjconf\ext\Extension>
     */
    protected $extensions           = array();
    /**
     * list of namespace definitions to merge with default one
     *
     * @var  array<net\xjconf\definitions\NamespaceDefinition>
     */
    protected $namespaceDefinitions = array();
    /**
     * the definition parser
     *
     * @var  net\xjconf\DefinitionParser
     */
    protected $definitionParser;
    /**
     * the xml parser
     *
     * @var  net\xjconf\XmlParser
     */
    protected $xmlParser;
    
    /**
     * construct the facade
     *
     * @param  array  $classLoaders<string,net\xjconf\XJConfClassLoader>  optional  list of class loaders for given namespaces
     */
    public function __construct(array $classLoaders = array())
    {
        $this->classLoaders = $classLoaders;
    }

    /**
     * add an extension that handles all tags in given namespace
     *
     * @param  net\xjconf\ext\Extension  $ext        use this extension to handle all tags in given namespace
     * @param  string                    $namespace  optional  handle all tags in this namespace with given extension
     */
    public function addExtension(Extension $ext, $namespace = null)
    {
        if (null == $namespace) {
            $namespace = $ext->getNamespace();
        }
        
        $this->extensions[$namespace] = $ext;
    }
    
    /**
     * enables xinclude
     */
    public function enableXIncludes()
    {
        $xincludeExtension = new \net\xjconf\ext\xinc\XInclude();
        $this->addExtension($xincludeExtension);
    }
    
    /**
     * add a namespace definition
     *
     * @param  net\xjconf\definitions\NamespaceDefinition  $namespaceDefinition
     */
    public function addNamespaceDefinition(NamespaceDefinition $namespaceDefinition)
    {
        $this->namespaceDefinitions[$namespaceDefinition->getNamespaceURI()] = $namespaceDefinition;
    }
    
    /**
     * add a namespace definition
     *
     * @param  net\xjconf\definitions\NamespaceDefinitions  $namespaceDefinitions
     */
    public function addNamespaceDefinitions(NamespaceDefinitions $namespaceDefinitions)
    {
        $this->namespaceDefinitions = array_merge($this->namespaceDefinitions, $namespaceDefinitions->getDefinedNamespaces());
    }
    
    /**
     * parses a definition and returns the namespace definitions
     *
     * @param   string                                       $definitionFile
     * @return  net\xjconf\definitions\NamespaceDefinitions
     */
    public function parseDefinition($definitionFile)
    {
        if (null === $this->definitionParser) {
            $this->definitionParser = new DefinitionParser($this->classLoaders);
        }
        
        return $this->definitionParser->parse($definitionFile);
    }
    
    /**
     * parses a definition file and adds its definitions
     *
     * @param  string  $definitionFile
     */
    public function addDefinition($definitionFile)
    {
        $this->addNamespaceDefinitions($this->parseDefinition($definitionFile));
    }
    
    /**
     * parses a definition file and adds its definitions
     *
     * @param  array  $definitions
     */
    public function addDefinitions(array $definitions)
    {
        foreach ($definitions as $definition) {
            $this->addNamespaceDefinitions($this->parseDefinition($definition));
        }
    }
    
    /**
     * parses a given file and creates the data structure described in this file
     *
     * @param   string                                     $filename
     * @throws  net\xjconf\exceptions\stubXJConfException
     */
    public function parse($filename)
    {
        if (null === $this->xmlParser) {
            $this->xmlParser = new XmlParser();
        }
        
        $namespaceDefinitions = new NamespaceDefinitions();
        foreach ($this->namespaceDefinitions as $namespaceURI => $namespaceDefintion) {
            $namespaceDefinitions->addNamespaceDefinition($namespaceURI, $namespaceDefintion);
        }
        
        $this->xmlParser->setTagDefinitions($namespaceDefinitions);
        foreach ($this->extensions as $namespace => $extension) {
            $this->xmlParser->addExtension($extension, $namespace);
        }
        
        $this->xmlParser->parse($filename);
    }
    
    /**
     * checks whether a data structure associated with this name exists
     *
     * @param   string               $name
     * @return  bool
     * @throws  net\xjconf\exceptions\XJConfException
     */
    public function hasConfigValue($name)
    {
        if (null === $this->xmlParser) {
            throw new \net\xjconf\exceptions\XJConfException('Invalid state: needs to parse first.');
        }
        
        return $this->xmlParser->hasConfigValue($name);
    }
    
    /**
     * returns the data structure associated with this name
     *
     * @param   string               $name
     * @return  mixed
     * @throws  \net\xjconf\exceptions\XJConfException
     */
    public function getConfigValue($name)
    {
        if (null === $this->xmlParser) {
            throw new \net\xjconf\exceptions\XJConfException('Invalid state: needs to parse first.');
        }
        
        return $this->xmlParser->getConfigValue($name);
    }
    
    /**
     * returns a list of all data structures
     *
     * @return  mixed
     * @throws  \net\xjconf\exceptions\XJConfException
     */
    public function getConfigValues()
    {
        if (null === $this->xmlParser) {
            throw new \net\xjconf\exceptions\XJConfException('Invalid state: needs to parse first.');
        }
        
        return $this->xmlParser->getConfigValues();
    }

    /**
     * clears parsed config values
     *
     * @throws  \net\xjconf\exceptions\XJConfException
     */
    public function clearConfigValues()
    {
        if (null == $this->xmlParser) {
            throw new \net\xjconf\exceptions\XJConfException('Invalid state: needs to parse first.');
        }
        
        $this->xmlParser->clearConfigValues();
    }
}
?>