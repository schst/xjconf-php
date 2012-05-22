<?php
/**
 * Generic Tag wrapper that can be used by extensions to dynamically add
 * children to other tags.
 *
 * @author   Stephan Schmidt <me@schst.net>
 * @author   Frank Kleine <mikey@xjconf.net>
 * @package  XJConf
 */
namespace net\xjconf;
/**
 * Generic Tag wrapper that can be used by extensions to dynamically add
 * children to other tags.
 *
 * @package  XJConf
 */
class GenericTag implements Tag
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
     * content of the tag (overrides data)
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
     * @var  mixed
     */
    private $value    = null;
    /**
     * Key of the tag
     *
     * @var  string
     */
    private $key      = null;

    /**
     * Create a new tag with or without attributes
     *
     * @param  string $name  name of the tag
     * @param  array  $atts  optional  list of attributes
     */
    public function __construct($name, $atts = array())
    {
        $this->name = $name;
        $this->atts = $atts;
    }

    /**
     * Get the name of the tag
     *
     * @return  string
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
        return $this->key;
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
     * @return  string
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
     * @param   Tag  $child  child to add
     * @return  int  number of childs added
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
        if (null !== $this->content) {
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
        return $this->value;
    }

    /**
     * Get the type of the value
     *
     * @return  string
     */
    public function getValueType(Tag $tag)
    {
        if (null === $this->value) {
            return null;
        }

        if (is_object($this->value) == true) {
            return get_class($this->value);
        }

        return gettype($this->value);
    }

    /**
     * Get the setter method
     */
    public function getSetterMethod()
    {
        if (null === $this->key) {
            return null;
        }
        
        return 'set' . ucfirst($this->key);
    }

    /**
     * Checks, whether the tag supports indexed children
     *
     * @return  boolean
     */
    public function supportsIndexedChildren()
    {
        return true;
    }

    /**
     * Set the value of the tag
     *
     * @param  mixed
     */
    public function setValue($value)
     {
        $this->value = $value;
    }

    /**
     * returns the definition for this tag
     *
     * @return  Definition
     */
    public function getDefinition()
    {
        return null;
    }
}
?>