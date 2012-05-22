<?php
/**
 * Base class to convert a value to an object.
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  converters
 */
namespace net\xjconf\converters;
use net\xjconf\Tag;
use net\xjconf\definitions\Definition;
use net\xjconf\definitions\TagDefinition;
use net\xjconf\definitions\ValueModifier;
use net\xjconf\exceptions\ValueConversionException;
/**
 * Base class to convert a value to an object.
 *
 * @package     XJConf
 * @subpackage  converters
 */
abstract class AbstractObjectValueConverter implements ValueConverter
{
    /**
     * Name of the target class
     *
     * @var  string
     */
    protected $className;

    /**
     * Enter description here...
     *
     * @param  net\xjconf\Tag                        $tag
     * @param  net\xjconf\definitions\TagDefinition  $def
     * @param  object                                $instance
     */
    protected function callMethods(Tag $tag, TagDefinition $def, $instance) {
        $children = $tag->getChildren();
        foreach ($children as $child) {
            if (!$child instanceof ValueModifier) {
                continue;
            }
        }
    }

    /**
     * Add all attributes using the appropriate setter methods
     *
     * @param   net\xjconf\Tag                        $tag
     * @param   net\xjconf\definitions\TagDefinition  $def
     * @param   object                                $instance
     * @throws  net\xjconf\exceptions\ValueConversionException
     */
    protected function addAttributesToValue(Tag $tag, TagDefinition $def, $instance)
    {
        $class = new \ReflectionClass(get_class($instance));
        // set all attributes
        foreach ($def->getAttributes() as $att) {
            $val = $att->convertValue($tag);
            // attribute has not been set and there is no
            // default value, skip the method call
            if (null === $val) {
                continue;
            }

            try {
                if ($class->hasMethod($att->getSetterMethod($tag)) == true) {
                    $method = $class->getMethod($att->getSetterMethod($tag));
                } elseif ($class->hasMethod('__set') == true) {
                    $method = $class->getMethod('__set');
                } elseif ($class->hasProperty($att->getName()) == true) {
                    $property = $class->getProperty($att->getName());
                    if ($property->isPublic() == true) {
                        $property->setValue($instance, $val);
                        continue;
                    }
                    
                    throw new ValueConversionException('Could not add attribute "' . $att->getName() . '" to "' . $this->getType() . '" using "' . $att->getSetterMethod($tag) . '()" or "__set()" or public property "' . $att->getName() . '", no such method defined.');
                } else {
                    throw new ValueConversionException('Could not add attribute "' . $att->getName() . '" to "' . $this->getType() . '" using "' . $att->getSetterMethod($tag) . '()" or "__set()" or public property "' . $att->getName() . '", no such method defined.');
                }
                
                if ($method->getName() != '__set') {
                    $method->invoke($instance, $val);
                } else {
                    $method->invokeArgs($instance, array($att->getName(), $val));
                }
            } catch (\ReflectionException $re) {
                throw new ValueConversionException('Could not set attribute "' . $att->getName() . '" of "' . $this->getType() . '" using "' . $att->getSetterMethod($tag) . '()" or "__set()" or public property "' . $att->getName() . '", exception message: "' . $re->getMessage() . '".');
            }
        }
    }

    /**
     * Add all children to the created instance
     *
     * @param   net\xjconf\Tag                     $tag
     * @param   net\xjconf\definitions\Definition  $def
     * @param   object                             $instance
     * @throws  net\xjconf\exceptions\ValueConversionException
     */
    protected function addChildrenToValue(Tag $tag, Definition $def, $instance, $ignore = array())
    {
        // traverse all children
        $children = $tag->getChildren();
        if (count($children) == 0) {
            return;
        }

        $class = new \ReflectionClass(get_class($instance));
        foreach ($children as $child) {

            if (in_array($child->getName(), $ignore) == true) {
                continue;
            }

            $childDef = $child->getDefinition();
            if ($childDef instanceof ValueModifier) {
                $childDef->modifyValue($instance, $child);
                continue;
            }
            
            try {
                if ($class->hasMethod($child->getSetterMethod()) == true) {
                    $method = $class->getMethod($child->getSetterMethod());
                } elseif ($class->hasMethod($child->getKey()) == true) {
                    $method = $class->getMethod($child->getKey());
                } elseif ($class->hasMethod('__set') == true) {
                    $method = $class->getMethod('__set');
                } elseif ($class->hasProperty($child->getKey()) == true) {
                    $property = $class->getProperty($child->getKey());
                    if ($property->isPublic() == true) {
                        $property->setValue($instance, $child->getConvertedValue());
                        continue;
                    }
                    
                    throw new ValueConversionException('Could not add child "' . $child->getKey() . '" to "' . $this->getType() . '" using "' . $child->getSetterMethod() . '()" or "' . $child->getKey() . '" or "__set()" or public property "' . $child->getKey() . '", no such method defined.');
                } else {
                    throw new ValueConversionException('Could not add child "' . $child->getKey() . '" to "' . $this->getType() . '" using "' . $child->getSetterMethod() . '()" or "' . $child->getKey() . '" or "__set()" or public property "' . $child->getKey() . '", no such method defined.');
                }
                
                if ($method->getName() != '__set') {
                    $method->invoke($instance, $child->getConvertedValue());
                } else {
                    $method->invokeArgs($instance, array($child->getName(), $child->getConvertedValue()));
                }
            } catch (\ReflectionException $re) {
                throw new ValueConversionException('Could not add child "' . $child->getKey() . '" to "' . $this->getType() . '" using "' . $child->getSetterMethod() . '()" or "' . $child->getKey() . '" or "__set()" or public property "' . $child->getKey() . '", exception message: "' . $re->getMessage() . '".');
            }
        }
    }

    /**
     * Add the CData to the value
     *
     * @param   net\xjconf\Tag                     $tag
     * @param   net\xjconf\definitions\Definition  $def
     * @param   object                             $instance
     * @throws  net\xjconf\exceptions\ValueConversionException
     */
    protected function addCDataToValue(Tag $tag, Definition $def, $instance, $ignore = array())
    {
        // check, whether the CData has been specifically defined
        if (!$def->hasChildDefinition('net\xjconf\definitions\CDataDefinition')) {
            return;
        }
        $cDataDefinition = $def->getChildDefinition('net\xjconf\definitions\CDataDefinition');
        $value = $cDataDefinition->convertValue($tag);
        try {
            $class = new \ReflectionClass(get_class($instance));
            $class->getMethod($cDataDefinition->getSetterMethod($tag))->invoke($instance, $value);
        } catch (\ReflectionException $re) {
            throw new ValueConversionException('Could not add cdata to "' . $this->getType() . '" using "' . $cDataDefinition->getSetterMethod($tag) . '()", exception message: "' . $re->getMessage() . '".');
        }
    }

    /**
     * returns the type of the converter
     *
     * @return  string
     */
    public function getType()
    {
        return $this->className;
    }
}
?>