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
class ConstructorValueConverter extends AbstractObjectValueConverter implements ValueConverter
{
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
     * @return  mixed  the converted value
     * @throws  net\xjconf\exceptions\ValueConversionException
     */
    public function convertValue(Tag $tag, Definition $def)
    {
        if (class_exists($this->className) == false) {
            throw new ValueConversionException('Class "' . $this->className . '" does not exist.');
        }

        $constructor = $def->getChildDefinition('net\xjconf\definitions\ConstructorDefinition');
        $tmpParams   = $constructor->getParams();
        $cParams     = array();
        // get all values and their types
        foreach ($tmpParams as $key => $conParam) {
            $cParams[] = $conParam->convertValue($tag);
        }

        // try to create a new instance
        try {
            $refClass  = new \ReflectionClass($this->className);
            if (count($cParams) > 1 && method_exists($refClass, 'newInstanceArgs') == true) {
                $instance = $refClass->newInstanceArgs($cParams);
            } elseif (count($cParams) == 1) {
                // check if the constructor has arguments
                // if the first argument has a type hint and we have an empty 
                // string replace this with an appropriate value
                $refMethod = $refClass->getConstructor();
                if (null != $refMethod) {
                    $params = $refMethod->getParameters();
                    if (count($params) >= 1 && $params[0]->getClass() != null && empty($cParams[0]) == true) {
                        $cParams[0] = null;
                    } elseif (count($params) >= 1 && $params[0]->isArray() == true && empty($cParams[0]) == true) {
                        if ($params[0]->allowsNull() == true) {
                            $cParams[0] = null;
                        } else {
                            $cParams[0] = array();
                        }
                    }
                }
                try {
                    $instance = $refClass->newInstance($cParams[0]);
                } catch (\ReflectionException $re) {
                    $instance = $refClass->newInstance();
                }
            } elseif (count($cParams) == 0) {
                $instance = $refClass->newInstance();
            } else {
                throw new ValueConversionException('Could not create instance of "' . $this->className . '" as Reflection does not support newInstanceArgs().');
            }
        } catch (\ReflectionException $re) {
            throw new ValueConversionException('Could not create instance of "' . $this->className . '": ' . $re->getMessage());
        }

        // add attributes and child elements
        if ($def instanceof TagDefinition) {
            $this->addAttributesToValue($tag, $def, $instance);
            $this->addCDataToValue($tag, $def, $instance);
        }
        $this->addChildrenToValue($tag, $def, $instance, $constructor->getUsedChildrenNames());

        return $instance;
    }
}
?>