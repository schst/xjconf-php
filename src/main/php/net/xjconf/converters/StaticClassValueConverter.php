<?php
/**
 * Class to convert a value to an object using the constructor of the object.
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
use net\xjconf\exceptions\ValueConversionException;
/**
 * Class to convert a value to an object using the constructor of the object.
 *
 * @package     XJConf
 * @subpackage  converters
 */
class StaticClassValueConverter implements ValueConverter
{
    /**
     * Name of the target class
     *
     * @var  string
     */
    protected $className;

    /**
     * Create a new converter
     *
     * @param  string  $className  name of the target class
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * converts the given values into the given types
     *
     * @param   net\xjconf\Tag                     $tag
     * @param   net\xjconf\definitions\Definition  $def
     * @return  null   no value is created
     * @throws  net\xjconf\exceptions\ValueConversionException
     */
    public function convertValue(Tag $tag, Definition $def)
    {
        if (class_exists($this->className) == false) {
            throw new ValueConversionException('Class "' . $this->className . '" does not exist.');
        }

        if ($def instanceof TagDefinition) {
            $this->addAttributesToValue($tag, $def);
        }
        $this->addChildrenToValue($tag, $def);
        return null;
    }

    /**
     * returns the type
     *
     * @return  string
     */
    public function getType() {
        return null;
    }

    /**
     * Add all attributes using the appropriate setter methods
     *
     * @param   net\xjconf\Tag                        $tag
     * @param   net\xjconf\definitions\TagDefinition  $def
     * @throws  net\xjconf\exceptions\ValueConversionException
     */
    protected function addAttributesToValue(Tag $tag, TagDefinition $def)
    {
        $class = new \ReflectionClass($this->className);
        // set all attributes
        foreach ($def->getAttributes() as $att) {
            $val = $att->convertValue($tag);
            // attribute has not been set and there is no
            // default value, skip the method call
            if (null === $val) {
                continue;
            }

            try {
                $method = $class->getMethod($att->getSetterMethod($tag));
                if (!$method->isStatic()) {
                    throw new ValueConversionException('Could not set attribute "' . $att->getName() . '" of "' . $this->getType() . '" using "' . $att->getSetterMethod() . '()" as the method is not static.');
                }
                
                $method->invoke(null, $val);
            } catch (\ReflectionException $re) {
                throw new ValueConversionException('Could not set attribute "' . $att->getName() . '" of "' . $this->getType() . '" using "' . $att->getSetterMethod() . '()", exception message: "' . $re->getMessage() . '".');
            }
        }
    }

    /**
     * Add all children to the static class
     *
     * @param   net\xjconf\Tag                     $tag
     * @param   net\xjconf\definitions\Definition  $def
     * @throws  net\xjconf\exceptions\ValueConversionException
     */
    protected function addChildrenToValue(Tag $tag, Definition $def)
    {
        // traverse all children
        $children = $tag->getChildren();
        if (count($children) == 0) {
            return;
        }

        $class = new \ReflectionClass($this->className);
        foreach ($children as $child) {
            try {
                $method = $class->getMethod($child->getSetterMethod());
                if (!$method->isStatic()) {
                    throw new ValueConversionException('Could not add child "' . $child->getKey() . '" to "' . $this->getType() . '" using "' . $child->getSetterMethod() . '()" as the method is not static.');
                }
                $method->invoke(null, $child->getConvertedValue());
            } catch (\ReflectionException $re) {
                throw new ValueConversionException('Could not add child "' . $child->getKey() . '" to "' . $this->getType() . '" using "' . $child->getSetterMethod() . '()", exception message: "' . $re->getMessage() . '".');
            }
        }
    }

}
?>