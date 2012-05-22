<?php
/**
 * Value converter that uses a factory method to create an object.
 *
 * @author      Stephan Schmidt <me@schst.net>
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
 * Value converter that uses a factory method to create an object.
 *
 * @package     XJConf
 * @subpackage  converters
 */
class FactoryMethodValueConverter extends AbstractObjectValueConverter implements ValueConverter
{
    /**
     * name of method to use as factory method
     *
     * @var  string
     */
    protected $methodName;

    /**
     * constructor
     *
     * @param  string  $className   name of class to use
     * @param  string  $methodName  name of method to use
     */
    public function __construct($className, $methodName)
    {
        $this->className  = $className;
        $this->methodName = $methodName;
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

        $factoryMethod = $def->getChildDefinition('net\xjconf\definitions\FactoryMethodDefinition');
        $tmpParams     = $factoryMethod->getParams();
        $cParams       = array();
        // get all values and their types
        foreach ($tmpParams as $key => $conParam) {
            $cParams[] = $conParam->convertValue($tag);
        }

        $instance = null;
        try {
            $refClass  = new \ReflectionClass($this->className);
            $refMethod = $refClass->getMethod($this->methodName);
            if (!$refMethod->isStatic()) {
                throw new ValueConversionException('Could not create instance of "' . $this->className . '" using the factory method "' . $this->methodName . '" as it is no static method.');
            }
            
            if (method_exists($refMethod, 'invokeArgs') == true) {
                $instance = $refMethod->invokeArgs(null, $cParams);
            } elseif (count($cParams) == 0) {
                $instance = $refMethod->invoke(null, null);
            } elseif (count($cParams) == 1) {
                $instance = $refMethod->invoke(null, $cParams[0]);
            } else {
                throw new ValueConversionException('Could not create instance of "' . $this->className . '" as Reflection does not support invokeArgs().');
            }
        } catch (\ReflectionException $re) {
            throw new ValueConversionException('Could not create instance of "' . $this->className . '" using the factory method "' . $this->methodName . '": ' . $re->getMessage());
        }

        if (null != $instance && get_class($instance) !== false) {
            // add attributes and child elements
            if ($def instanceof TagDefinition) {
                $this->addAttributesToValue($tag, $def, $instance);
                $this->addCDataToValue($tag, $def, $instance);
            }
            $this->addChildrenToValue($tag, $def, $instance, $factoryMethod->getUsedChildrenNames());
        }

        return $instance;
    }
}
?>