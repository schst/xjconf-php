<?php
/**
 * Converter to convert a value into a primitive
 * by trying to guess its type
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
 * Converter to convert a value into a primitive
 * by trying to guess its type
 *
 * @package     XJConf
 * @subpackage  converters
 */
class AutoPrimitiveValueConverter implements ValueConverter
{
    /**
     * converts the given values into the given types
     *
     * @param   net\xjconf\Tag                     $tag
     * @param   net\xjconf\definitions\Definition  $def
     * @return  mixed
     */
    public function convertValue(Tag $tag, Definition $def) {
        $value = $tag->getData();

        if ($value === 'null') {
            return null;
        }
        if ($value === 'true') {
            return true;
        }
        if ($value === 'false') {
            return false;
        }

        if (preg_match('/^[+-]?[0-9]+$/', $value)) {
            settype($value, 'int');
            return $value;
        }
        if (preg_match('/^[+-]?[0-9]*\.[0-9]+$/', $value)) {
            settype($value, 'double');
            return $value;
        }
        return $value;
    }

   /**
     * Returns the type of the converter
     *
     * @return  string
     */
    public function getType() {
        return null;
    }
}
?>