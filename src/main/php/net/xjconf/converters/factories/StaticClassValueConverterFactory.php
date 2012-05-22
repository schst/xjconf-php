<?php
/**
 * Factory to create a StaticClassValueConverter.
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  converters_factories
 */
namespace net\xjconf\converters\factories;
use net\xjconf\converters\StaticClassValueConverter;
use net\xjconf\definitions\Definition;
/**
 * Factory to create an StaticClassValueConverter.
 *
 * @package     XJConf
 * @subpackage  converters_factories
 */
class StaticClassValueConverterFactory implements ValueConverterFactory
{

    /**
     * Decides whether the ConstructorValueConverter is responsible for the given Definition.
     *
     * @param   net\xjconf\definitions\Definition  $def
     * @return  boolean     true if is responsible, else false
     */
    public function isResponsible(Definition $def)
    {
        if (class_exists($def->getType()) === false) {
            return false;
        }

        if (($def instanceof TagDefinition) === false) {
            return false;
        }
        
        return $def->isStatic();
    }

    /**
     * creates an instance of the ConstructorValueConverter
     *
     * @param   net\xjconf\definitions\Definition                $def
     * @return  net\xjconf\converters\ConstructorValueConverter
     */
    public function createValueConverter(Definition $def)
    {
        $converter = new StaticClassValueConverter($def->getType());
        return $converter;
    }
}
?>