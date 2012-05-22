<?php
/**
 * Converter to convert a value to a primitive type.
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  converters
 */
namespace net\xjconf\converters;
use net\xjconf\Tag;
use net\xjconf\definitions\Definition;

/**
 * Converter to convert a value to a primitive type.
 *
 * @package     XJConf
 * @subpackage  converters
 */
class PrimitiveValueConverter implements ValueConverter
{
    /**
     * Type of the primitive
     *
     * @var  string
     */
    private $type;

    /**
     * Create a new converter
     * @param type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * converts the given values into the given types
     *
     * @param   net\xjconf\Tag                     $tag
     * @param   net\xjconf\definitions\Definition  $def
     * @return  mixed  the converted value
     */
    public function convertValue(Tag $tag, Definition $def) {
        $value = $tag->getData();
        
        switch ($this->type) {
            case 'boolean':
            case 'bool':
                if ('false' === $value) {
                    return false;
                }
                
                return (boolean) $value;
            case 'integer':
            case 'int':
                if ('0' === $value{0}) {
                    return octdec($value);
                }
                
                return (integer) $value;
            case 'double':
                return (double) $value;
            case 'float':
                return (float) $value;
            case 'string':
                return (string) $value;
        }
        return null;
    }

   /**
     * returns the type of the converter
     *
     * @return  string
     */
    public function getType()
    {
        switch ($this->type) {
            case 'boolean':
            case 'bool':
            case 'integer':
            case 'int':
            case 'double':
            case 'float':
            case 'string':
                return $this->type;
        }

        return null;
    }
}
?>