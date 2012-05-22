<?php
/**
 * Interface for a value converter.
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
 * Interface for a value converter.
 *
 * @package     XJConf
 * @subpackage  converters
 */
interface ValueConverter
{
    /**
     * converts the given values into the given types
     *
     * @param   net\xjconf\Tag                     $tag
     * @param   net\xjconf\definitions\Definition  $def
     * @return  mixed  the converted value
     * @throws  net\xjconf\exceptions\ValueConversionException
     */
    public function convertValue(Tag $tag, Definition $def);

    /**
     * returns the type of the converter
     *
     * @return  string
     */
    public function getType();
}
?>