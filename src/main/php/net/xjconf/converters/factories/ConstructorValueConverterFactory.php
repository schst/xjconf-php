<?php
/**
 * Factory to create a ConstructorValueConverter.
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  converters_factories
 */
namespace net\xjconf\converters\factories;
use net\xjconf\converters\ConstructorValueConverter;
use net\xjconf\definitions\Definition;
/**
 * Factory to create an ConstructorValueConverter.
 *
 * @package     XJConf
 * @subpackage  converters_factories
 */
class ConstructorValueConverterFactory implements ValueConverterFactory
{
    /**
     * Decides whether the ConstructorValueConverter is responsible for the given Definition.
     *
     * @param   net\xjconf\definitions\Definition  $def
     * @return  boolean     true if is responsible, else false
     */
    public function isResponsible(Definition $def)
    {
        if (class_exists($def->getType()) == false) {
            return false;
        }
        
        return $def->hasChildDefinition('net\xjconf\definitions\ConstructorDefinition');
    }

    /**
     * creates an instance of the ConstructorValueConverter
     *
     * @param   net\xjconf\definitions\Definition                $def
     * @return  net\xjconf\converters\ConstructorValueConverter
     */
    public function createValueConverter(Definition $def)
    {
        $converter = new ConstructorValueConverter($def->getType());
        return $converter;
    }
}
?>