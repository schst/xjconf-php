<?php
/**
 * Contains data of tag in the default namespace.
 *
 * @author   Stephan Schmidt <me@schst.net>
 * @author   Frank Kleine <mikey@xjconf.net>
 * @package  XJConf
 */
namespace net\xjconf;
use net\xjconf\definitions\Definition;
use net\xjconf\definitions\ConcreteTagDefinition;
use net\xjconf\definitions\TagDefinition;
/**
 * Contains data of tag in the default namespace.
 *
 * @package  XJConf
 */
class DefinedTag implements Tag
{
    /**
     * name of the tag
     *
     * @var  string
     */
    private $name     = null;
    /**
     * character data
     *
     * @var  string
     */
    private $data     = null;
    /**
     * content of the tag
     *
     * @var  mixed
     */
    private $content  = null;
    /**
     * attributes of the tag
     *
     * @var  array
     */
    private $atts     = array();
    /**
     * Children of the tag
     *
     * @var  array
     */
    private $children = array();
    /**
     * value of the tag
     *
     * @var  TagDefinition
     */
    private $tagDef   = null;

    /**
     * Create a new tag without attributes
     *
     * @param name   name of the tag
     */
    public function __construct($name, $atts = array())
    {
        $this->name = $name;
        $this->atts = $atts;
    }

    /**
     * Get the name of the tag
     *
     * @return   name of the tag
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the key
     *
     * @param  string  $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Get the key under which the value will be stored
     *
     * @return  string
     */
    public function getKey()
    {
        return $this->tagDef->getKey($this);
    }

    /**
     * Add text data
     *
     * @param   string  $buf
     * @return  int     new length of data
     */
    public function addData($buf)
    {
        $this->data .= $buf;
        return strlen($this->data);
    }

    /**
     * Get the character data of the tag
     *
     * @return   character data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Check, whether the tag has a certain attribute
     *
     * @param   string   $name
     * @return  boolean
     */
    public function hasAttribute($name)
    {
        return isset($this->atts[$name]);
    }

    /**
     * get an attribute
     *
     * @param   string  $name  name of the attribute
     * @return  string  value of the attribute
     */
    public function getAttribute($name)
    {
        if ($this->hasAttribute($name) === true) {
            return $this->atts[$name];
        }

        return null;
    }

    /**
     * get all attributes
     *
     * @return  array
     */
    public function getAttributes()
    {
        return $this->atts;
    }

    /**
     * Add a new child to this tag.
     *
     * @param child  child to add
     * @return   int    number of childs added
     */
    public function addChild(Tag $child)
    {
        array_push($this->children, $child);
        return count($this->children);
    }

    /**
     * Get the child with a specific name
     *
     * @param   string  $name
     * @return  Tag
     */
    public function getChild($name)
    {
        foreach ($this->children as $child) {
            if ($child->getName() === $name) {
                return $child;
            }
        }

        return null;
    }

    /**
     * Get all children of the tag
     *
     * @return  array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set the content (overrides the character data)
     *
     * @param  mixed  $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get the content
     *
     * @return  mixed
     */
    public function getContent()
    {
        if (null != $this->content) {
            return $this->content;
        }

        return $this->getData();
    }

    /**
     * Fetch the value
     *
     * @return    mixed  the value of the tag
     */
    public function getConvertedValue()
    {
        return $this->tagDef->convertValue($this);
    }

    /**
     * Get the type of the value
     *
     * @param   Tag     $tag
     * @return  string
     */
    public function getValueType(Tag $tag)
    {
        return $this->tagDef->getValueType($tag);
    }

    /**
     * Get the setter method
     *
     * @return  string
     */
    public function getSetterMethod()
    {
        return $this->tagDef->getSetterMethod($this);
    }

    /**
     * Checks, whether the tag supports indexed children
     *
     * @return  boolean
     */
    public function supportsIndexedChildren()
    {
        return $this->tagDef->supportsIndexedChildren();
    }

    /**
    * Set the tag definition object used for this tag
    *
    * @param  TagDefinition  $tagDef
    */
    public function setDefinition(Definition $tagDef)
    {
        if ($tagDef instanceof ConcreteTagDefinition) {
            $this->tagDef = $tagDef;
            return;
        }

        $this->tagDef = clone $tagDef;
        if ($tagDef instanceof TagDefinition) {
            $this->tagDef->setType($this->getAttribute($this->tagDef->getConcreteTypeAttributeName()));
        }
    }

    /**
     * get the tag definition object used for this tag
     *
     * @return  TagDefinition
     */
    public function getDefinition()
    {
        return $this->tagDef;
    }
}
?>