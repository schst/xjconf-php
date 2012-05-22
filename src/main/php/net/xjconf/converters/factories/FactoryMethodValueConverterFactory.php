<?php
/**
 * Factory to create a FactoryMethodValueConverter.
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  converters_factories
 */
namespace net\xjconf\converters\factories;
use net\xjconf\converters\FactoryMethodValueConverter;
use net\xjconf\definitions\Definition;
/**
 * Factory to create an FactoryMethodValueConverter.
 *
 * @package     XJConf
 * @subpackage  converters_factories
 */
class FactoryMethodValueConverterFactory implements ValueConverterFactory
{
    /**
     * Decides whether the FactoryMethodValueConverter is responsible for the given Definition.
     *
     * @param   net\xjconf\definitions\Definition  $def
     * @return  boolean     true if is responsible, else false
     */
    public function isResponsible(Definition $def)
    {
        if (class_exists($def->getType()) === false) {
            return false;
        }
        
        return $def->hasChildDefinition('net\xjconf\definitions\FactoryMethodDefinition');
    }

    /**
     * creates an instance of the FactoryMethodValueConverter
     *
     * @param   net\xjconf\definitions\Definition                  $def
     * @return  net\xjconf\converters\FactoryMethodValueConverter
     */
    public function createValueConverter(Definition $def)
    {
        $factoryMethod = $def->getChildDefinition('net\xjconf\definitions\FactoryMethodDefinition');
        if (null === $factoryMethod) {
            return null;
        }
        
        $converter = new FactoryMethodValueConverter($def->getType(), $factoryMethod->getName());
        return $converter;
    }
}
?>