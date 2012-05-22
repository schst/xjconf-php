<?php
/**
 * Converter to convert a value to an array.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  converters
 */
namespace net\xjconf\converters;
use net\xjconf\Tag;
use net\xjconf\definitions\Definition;
use net\xjconf\definitions\TagDefinition;
/**
 * Converter to convert a value to an array.
 *
 * @package     XJConf
 * @subpackage  converters
 */
class ArrayValueConverter implements ValueConverter
{
    /**
     * converts the given values into the given types
     *
     * @param   net\xjconf\Tag                     $tag
     * @param   net\xjconf\definitions\Definition  $def
     * @return  array
     */
    public function convertValue(Tag $tag, Definition $def)
    {
        $return = array();
        $return = $this->addAttributesToValue($tag, $def, $return);
        $return = $this->addChildrenToValue($tag, $def, $return);
        return $return;
    }

   /**
     * returns the type of the converter
     *
     * @return  string
     */
    public function getType()
    {
        return 'array';
    }
    
    /**
     * Add all attributes using the appropriate setter methods
     *
     * @param   net\xjconf\Tag                        $tag
     * @param   net\xjconf\definitions\TagDefinition  $def
     * @param   array          $array
     */
    protected function addAttributesToValue(Tag $tag, TagDefinition $def, $array)
    {
        // set all attributes
        foreach ($def->getAttributes() as $att) {
            $val = $att->convertValue($tag);
            // attribute has not been set and there is no
            // default value, skip the method call
            if (null === $val) {
                continue;
            }

            $array[$att->getName()] = $val;
        }
        
        return $array;
    }
    
    /**
     * Add all children to the created instance
     *
     * @param   net\xjconf\Tag                     $tag
     * @param   net\xjconf\definitions\Definition  $def
     * @param   array                              $array
     */
    protected function addChildrenToValue(Tag $tag, Definition $def, $array)
    {
        // traverse all children
        $children = $tag->getChildren();
        if (count($children) == 0) {
            return $array;
        }
        
        foreach ($children as $child) {
            if (null != $child->getContent()) {
                $val = $child->getContent();
            } else {
                $val = $child->getConvertedValue();
            }
            
            if (null === $val) {
                continue;
            }
            
            if ($child->getKey() === null || $child->getKey() == '__none' || strlen($child->getKey()) === 0) {
                $array[] = $val;
            } else {
                $array[$child->getKey()] = $val;
            }
        }
        
        return $array;
    }
}
?>