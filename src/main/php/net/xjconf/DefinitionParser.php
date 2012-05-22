<?php
/**
 * Parse tag definitions files.
 *
 * @author   Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author   Frank Kleine <mikey@xjconf.net>
 * @package  XJConf
 */
namespace net\xjconf;
use net\xjconf\definitions\AttributeDefinition;
use net\xjconf\definitions\CDataDefinition;
use net\xjconf\definitions\ChildDefinition;
use net\xjconf\definitions\ConstructorDefinition;
use net\xjconf\definitions\FactoryMethodDefinition;
use net\xjconf\definitions\MethodCallTagDefinition;
use net\xjconf\definitions\NamespaceDefinition;
use net\xjconf\definitions\NamespaceDefinitions;
use net\xjconf\definitions\TagDefinition;
use net\xjconf\definitions\handler\DefinitionHandlerFactory;
use net\xjconf\exceptions\InvalidNamespaceDefinitionException;
use net\xjconf\exceptions\XJConfException;
/**
 * Parse tag definitions files.
 *
 * This parser reads xml files that define the tags used by other
 * xml documents which describe a data structure.
 *
 * @package  XJConf
 */
class DefinitionParser
{
    /**
     * this tag defines a namespace
     */
    const TAG_NAMESPACE      = 'namespace';
    /**
     * stack for currently open definitions
     *
     * @var  array<Definition>
     */
    private $defStack        = array();
    /**
     * stack for currently opened definition handlers
     *
     * @var  DefinitionHandler
     */
    private $defHandlerStack = array();
    /**
     * Constant for the default namespace
     */
    const DEFAULT_NAMESPACE  = '__default';
    /**
     * The current namespace
     *
     * @var  string
     */
    private $currentNamespace;
    /**
     * All extracted namespace definitions
     *
     * @var  NamespaceDefinitions
     */
    private $defs;
    /**
     * the real xml parser
     *
     * @var  XMLReader
     */
    private $reader;
    /**
     * list of node types, used for compatibility between PHP 5.0 and 5.1
     *
     * @var  array
     */
    private $nodeTypes       = array();
    /**
     * hashmap of class loaders where the key is the namespace the class loader
     *  should be used for
     *
     * @var  array<String,XJConfClassLoader>
     */
    private $classLoaders    = array();

    /**
     * constructor
     *
     * Sets the node types depending on your PHP version using the constants
     * defined by the XMLReader PHP extension.
     *
     * @param  array<String,XJConfClassLoader>  $classLoaders  optional
     */
    public function __construct($classLoaders = array())
    {
        $this->defs             = new NamespaceDefinitions();
        $this->currentNamespace = self::DEFAULT_NAMESPACE;
        $this->classLoaders     = $classLoaders;
        $this->nodeTypes        = array('startTag' => \XMLReader::ELEMENT,
                                        'text'     => \XMLReader::TEXT,
                                        'endTag'   => \XMLReader::END_ELEMENT
                                  );
    }

    /**
     * returns the current namespace
     *
     * @return  string
     */
    public function getCurrentNamespace()
    {
        return $this->currentNamespace;
    }

    /**
     * returns the list of created namespace definitions
     *
     * @return  NamespaceDefinitions
     */
    public function getNamespaceDefinitions()
    {
        return $this->defs;
    }

    /**
     * check whether a class loader exists for given namespace
     *
     * @param   string  $namespace
     * @return  bool
     */
    public function hasClassLoader($namespace)
    {
        return (isset($this->classLoaders[$namespace]) == true || isset($this->classLoaders['__default']) == true);
    }

    /**
     * return the class loader for the given namespace
     *
     * @param   string             $namespace
     * @return  XJConfClassLoader
     */
    public function getClassLoader($namespace)
    {
        if (isset($this->classLoaders[$namespace]) == true) {
            return $this->classLoaders[$namespace];
        }
        
        if (isset($this->classLoaders['__default']) == true) {
            return $this->classLoaders['__default'];
        }

        return null;
    }

    /**
     * returns the definition stack
     *
     * @return  array<Definition>
     */
    public function &getDefStack()
    {
        return $this->defStack;
    }

    /**
     * initializes the parser
     */
    private function initParser()
    {
        if (null === $this->reader) {
            $this->reader = new \XMLReader();
        }
    }

    /**
     * parse a tag definitions file and return
     * an instance of NamespaceDefinition
     *
     * @param   string               $filename  filename of the defintions file
     * @return  NamespaceDefinition
     * @throws  XJConfException
     * @throws  InvalidNamespaceDefinitionException
     */
    public function parse($filename)
    {
        $this->initParser();
        if (@$this->reader->open($filename) === false) {
            throw new XJConfException('Can not open file ' . $filename);
        }
        
        while ($this->reader->read()) {
            switch ($this->reader->nodeType) {
                case $this->nodeTypes['startTag']:
                    $nameSpaceURI = $this->reader->namespaceURI;
                    $elementName  = $this->reader->localName;
                    $attributes   = array();
                    $empty = $this->reader->isEmptyElement;
                    if (true === $this->reader->hasAttributes) {
                        // go to first attribute
                        $attribute = $this->reader->moveToFirstAttribute();
                        // save data of all attributes
                        while (true === $attribute) {
                            $attributes[$this->reader->localName] = $this->reader->value;
                            $attribute = $this->reader->moveToNextAttribute();
                        }
                    }
                    $this->startElement($nameSpaceURI, $elementName, $attributes);
                    if (true === $empty) {
                        $this->endElement($nameSpaceURI, $elementName);
                    }
                    break;

                case $this->nodeTypes['text']:
                    $this->characters($this->reader->value);
                    break;

                case $this->nodeTypes['endTag']:
                    $this->endElement($this->reader->namespaceURI, $this->reader->localName);
                    break;
            }
        }

        $this->reader->close($filename);

        return $this->defs;
    }

    /**
     * Start Element handler
     *
     * Creates the Definition object and places it on
     * the stack.
     *
     * @param   string  $namespaceURI  namespace of start tag
     * @param   string  $sName         name of start tag
     * @param   array   $atts          attributes of tag
     * @throws  InvalidNamespaceDefinitionException
     */
    private function startElement($namespaceURI, $sName, $atts)
    {
        // a new namespace
        if (self::TAG_NAMESPACE  === $sName) {
            if (isset($atts['uri']) === false) {
                throw new InvalidNamespaceDefinitionException('The <' . self::TAG_NAMESPACE . '> tag is missing the uri attribute.');
            }

            // change current namespace to new namespace
            $this->currentNamespace = $atts['uri'];
            return;
        }

        // create the appropriate definition handler and use this
        // to create the required definition
        $defHandler = DefinitionHandlerFactory::create($sName, $this);
        $def        = $defHandler->startElement($namespaceURI, $sName, $atts);
        if (null != $def) {
            array_push($this->defStack, $def);
        }

        array_push($this->defHandlerStack, $defHandler);
    }

    /**
     * End Element handler
     *
     * Fetches the Definition from the stack and
     * adds it to the NamespaceDefinition object.
     *
     * @param   string  $namespaceURI  namespace of end tag
     * @param   string  $sName         name of end tag
     */
    private function endElement($namespaceURI, $sName)
    {
        // namespace definition ends, switch back to default namespace
        if (self::TAG_NAMESPACE  === $sName) {
            $this->currentNamespace = self::DEFAULT_NAMESPACE;
            return;
        }

        // use definition handler to finalize the definition of the current tag
        $defHandler = array_pop($this->defHandlerStack);
        $defHandler->endElement($namespaceURI, $sName);
    }
}
?>