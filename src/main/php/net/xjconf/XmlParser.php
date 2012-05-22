<?php
/**
 * Parser that reads xml files and generates the data structure.
 *
 * @author   Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author   Frank Kleine <mikey@xjconf.net>
 * @package  XJConf
 */
namespace net\xjconf;
use net\xjconf\definitions\NamespaceDefinition;
use net\xjconf\definitions\NamespaceDefinitions;
use net\xjconf\exceptions\UnknownNamespaceException;
use net\xjconf\exceptions\UnknownTagException;
use net\xjconf\exceptions\XJConfException;
use net\xjconf\ext\Extension;
/**
 * Parser that reads xml files and generates the data structure.
 *
 * This parser reads xml files using the tag definitions and
 * created the data structure and objects described by tag
 * definitions and the xml file.
 *
 * @package  XJConf
 */
class XmlParser
{
    /**
     * the list of tags that have to be processed
     *
     * @var  array<net\xjconf\Tag>
     */
    private $tagStack    = array();
    /**
     * hashmap of generated data types
     *
     * @var  array<string, mixed>
     */
    private $config      = array();
    /**
     * a listof defined namespaces
     *
     * @var  net\xjconf\definitions\NamespaceDefinitions
     */
    private $tagDefs;
    /**
     * current depth within the parsed document
     *
     * @var  int
     */
    private $depth       = 0;
    /**
     * list of extensions to use for the namespace
     *
     * @var  array<string, net\xjconf\ext\Extension>
     */
    private $extensions  = array();
    /**
     * the default namespace if none is set
     *
     * @var  string
     */
    private $myNamespace = 'http://xjconf.net/XJConf';
    /**
     * stack of currently opened files
     *
     * @var  array<string>
     */
    private $openFiles   = array();

    /**
     * list of node types, used for compatibility between PHP 5.0 and 5.1
     *
     * @var  array
     */
    private $nodeTypes   = array();

    /**
     * constructor
     *
     * Sets the node types depending on your PHP version using the constants
     * defined by the XMLReader PHP extension.
     */
    public function __construct()
    {
        $this->nodeTypes = array('startTag' => \XMLReader::ELEMENT,
                                 'text'     => \XMLReader::TEXT,
                                 'endTag'   => \XMLReader::END_ELEMENT
                           );
    }

    /**
     * set the list of namespace defintions
     *
     * @param  net\xjconf\definitions\NamespaceDefinitions  $tagDefs
     */
    public function setTagDefinitions(NamespaceDefinitions $tagDefs)
    {
        $this->tagDefs = $tagDefs;
    }

    /**
     * add some more namespace definitions
     *
     * @param  net\xjconf\definitions\NamespaceDefinitions  $tagDefs
     */
    public function addTagDefinitions(NamespaceDefinitions $tagDefs)
    {
        if (null == $this->tagDefs) {
            $this->setTagDefinitions($tagDefs);
            return;
        }

        $this->tagDefs->appendNamespaceDefinitions($tagDefs);
    }

    /**
     * add an extension that handles all tags in given namespace
     *
     * @param  string                    $namespace  handle all tags in this namespace with given extension
     * @param  net\xjconf\ext\Extension  $ext        use this extension to handle all tags in given namespace
     */
    public function addExtension(Extension $ext, $namespace = null)
    {
        if ($namespace == null) {
            $namespace = $ext->getNamespace();
        }
        
        $this->extensions[$namespace] = $ext;
    }

    /**
     * parses a given file and creates the data structure described in this file
     *
     * @param   string  $filename
     * @throws  net\xjconf\exceptions\XJConfException
     */
    public function parse($filename)
    {
        $reader = $this->initParser();
        array_push($this->openFiles, $filename);
        if (@$reader->open($filename) === false) {
            throw new XJConfException('Can not open file ' . $filename);
        }
        
        while ($reader->read()) {
            switch ($reader->nodeType) {
                case $this->nodeTypes['startTag']:
                    $empty = $reader->isEmptyElement;
                    $nameSpaceURI = $reader->namespaceURI;
                    $elementName  = $reader->localName;
                    $attributes   = array();
                    if (true === $reader->hasAttributes) {
                        // go to first attribute
                        $attribute = $reader->moveToFirstAttribute();
                        // save data of all attributes
                        while (true === $attribute) {
                            $attributes[$reader->localName] = $reader->value;
                            $attribute = $reader->moveToNextAttribute();
                        }
                    }

                    $this->startElement($nameSpaceURI, $elementName, $attributes);
                    if (true === $empty) {
                        $this->endElement($nameSpaceURI, $elementName);
                    }
                    break;

                case $this->nodeTypes['text']:
                    $this->characters($reader->value);
                    break;

                case $this->nodeTypes['endTag']:
                    $this->endElement($reader->namespaceURI, $reader->localName);
                    break;
            }
        }

        $reader->close($filename);
        array_pop($this->openFiles);

    }
    
    /**
     * checks whether a config value exists or not
     *
     * @return  bool
     */
    public function hasConfigValue($name)
    {
        return isset($this->config[$name]);
    }

    /**
     * returns the data structure associated with this name
     *
     * @param   string  $name
     * @return  mixed
     */
    public function getConfigValue($name)
    {
        if ($this->hasConfigValue($name) === true) {
            return $this->config[$name];
        }
        
        return null;
    }
    
    /**
     * returns all config values as array
     *
     * @return  array
     */
    public function getConfigValues()
    {
        return $this->config;
    }

    /**
     * clears parsed config values
     */
    public function clearConfigValues()
    {
        $this->config = array();
    }

    /**
     * returns the name of the file that is currently parsed
     *
     * @return  string
     */
    public function getCurrentFile()
    {
        return end($this->openFiles);
    }

    /**
     * initializes the parser
     */
    private function initParser()
    {
        $reader = new \XMLReader();
        return $reader;
    }

    /**
     * handles the start element
     *
     * Creates a new Tag object and pushes it
     * onto the stack.
     *
     * @param   string  $namespaceURI  namespace of start tag
     * @param   string  $sName         name of start tag
     * @param   array   $atts          attributes of tag
     * @throws  net\xjconf\exceptions\UnknownNamespaceException
     * @throws  net\xjconf\exceptions\UnknownTagException
     */
    private function startElement($namespaceURI, $sName, $atts)
    {
        // do not handle stuff in our own namespace
        if ($this->myNamespace === $namespaceURI && 0 < $this->depth) {
            return;
        }
        $this->depth++;

        // no namespace defined, use the default namespace
        if (strlen($namespaceURI) === 0) {
            $namespaceURI = '__default';
        }

        // ignore the root tag
        if (1 === $this->depth) {
            return;
        }

        // This tag needs to be handled by an extension
        if (isset($this->extensions[$namespaceURI]) === true) {
            $tag = new GenericTag($sName, $atts);
            $this->extensions[$namespaceURI]->startElement($this, $tag);
        // This tag has been defined internally
        } else {
            if ($this->tagDefs->isNamespaceDefined($namespaceURI) === false) {
                throw new UnknownNamespaceException('Unknown namespace ' . $namespaceURI . ' in file ' . end($this->openFiles));
            }

            $newDef  = null;
            $lastTag = end($this->tagStack);
            if ($lastTag instanceof Tag) {
                $lastDef = $lastTag->getDefinition();
                if (null !== $lastDef) {
                    $newDef = $lastDef->getChildDefinitionByTagName($sName);
                }
            }
            
            if (null === $newDef) {
                if ($this->tagDefs->isTagDefined($namespaceURI, $sName) === false) {
                    throw new UnknownTagException('Unknown tag ' . $sName . ' in namespace ' . $namespaceURI);
                }
                
                $newDef = $this->tagDefs->getTagDefinition($namespaceURI, $sName);
            }

            $tag = new DefinedTag($sName, $atts);
            // fetch the defintion for this tag
            $tag->setDefinition($newDef);
        }

        array_push($this->tagStack, $tag);
    }

    /**
     * handles the end element
     *
     * Fetches the current element from the stack and
     * converts it to the correct type.
     *
     * @param  string  $namespaceURI  namespace of end tag
     * @param  string  $sName         name of end tag
     */
    private function endElement($namespaceURI, $sName)
    {
        // do not handle stuff in our own namespace
        if ($this->myNamespace === $namespaceURI && 0 < $this->depth) {
            return;
        }
        $this->depth--;

        // no namespace defined, use the default namespace
        if (strlen($namespaceURI) === 0) {
            $namespaceURI = '__default';
        }

        // ignore the root tag
        if (0 === $this->depth) {
            return;
        }

        // get the last tag from the stack
        $tag = array_pop($this->tagStack);

        // This tag needs to be handled by an extension
        if (isset($this->extensions[$namespaceURI]) === true) {
            $result = $this->extensions[$namespaceURI]->endElement($this, $tag);
            if (null != $result) {
                if (1 == $this->depth) {
                    $this->config[$tag->getKey()] = $result->getConvertedValue();
                } else {
                    $parent = array_pop($this->tagStack);
                    if ($result->getKey() == null && $parent->supportsIndexedChildren() === false) {
                        $parent->setContent($result->getConvertedValue());
                    } else {
                        $parent->addChild($result);
                    }
                    
                    array_push($this->tagStack, $parent);
                }
            }
        // last tag before returning to root
        } elseif (1 === $this->depth) {
            $this->config[$tag->getKey()] = $tag->getConvertedValue();
        // add this tag to the tag before as child
        } else {
            $parent = array_pop($this->tagStack);
            $parent->addChild($tag);
            array_push($this->tagStack, $parent);
        }
    }

    /**
     * Character data handler
     *
     * Fetches the current tag from the stack and
     * appends the data.
     *
     * @param  string  $buf
     */
    private function characters($buf)
    {
        if (count($this->tagStack) === 0) {
            return;
        }

        $tag = end($this->tagStack);
        $tag->addData($buf);
    }
}
?>