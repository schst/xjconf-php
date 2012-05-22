<?php
/**
 * Interface for holding tag data.
 *
 * @author   Stephan Schmidt <me@schst.net>
 * @author   Frank Kleine <mikey@xjconf.net>
 * @package  XJConf
 */
namespace net\xjconf;
/**
 * Interface for holding tag data.
 *
 * @package  XJConf
 */
interface Tag
{
    /**
     * Get the name of the tag
     *
     * @return  name of the tag
     */
    public function getName();

    /**
     * Get the key under which the value will be stored
     *
     * @return  string
     */
    public function getKey();

    /**
     * Add text data
     *
     * @param   string  $buf
     * @return  int     new length of data
     */
    public function addData($buf);

    /**
     * Get the character data of the tag
     *
     * @return   character data
     */
    public function getData();

    /**
     * Check, whether the tag has a certain attribute
     *
     * @param   string   $name
     * @return  boolean
     */
    public function hasAttribute($name);

    /**
     * get an attribute
     *
     * @param   string  $name  name of the attribute
     * @return  string  value of the attribute
     */
    public function getAttribute($name);

    /**
     * get all attributes
     *
     * @return  array
     */
    public function getAttributes();

    /**
     * Add a new child to this tag.
     *
     * @param child  child to add
     * @return   int    number of childs added
     */
    public function addChild(Tag $child);

    /**
     * Get the child with a specific name
     *
     * @param   string  $name
     * @return  Tag
     */
    public function getChild($name);

    /**
     * Get all children of the tag
     *
     * @return  array
     */
    public function getChildren();

    /**
     * Set the content (overrides the character data)
     *
     * @param  mixed  $content
     */
    public function setContent($content);

    /**
     * Get the content
     *
     * @return  mixed
     */
    public function getContent();

    /**
     * Fetch the value
     *
     * @return    mixed  the value of the tag
     */
    public function getConvertedValue();

    /**
     * Get the type of the value
     *
     * @param   Tag     $tag
     * @return  string
     */
    public function getValueType(Tag $tag);

    /**
     * Get the setter method
     *
     * @return  string
     */
    public function getSetterMethod();

    /**
     * returns the definition for this tag
     *
     * @return  Definition
     */
    public function getDefinition();

    /**
     * Checks, whether the tag supports indexed children
     *
     * @return  boolean
     */
    public function supportsIndexedChildren();
}
?>