<?php
/**
 * Factory to create an ArrayValueConverter.
 * 
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  converters_factories
 */
namespace net\xjconf\converters\factories;
use net\xjconf\converters\ArrayValueConverter;
use net\xjconf\definitions\Definition;
/**
 * Factory to create an ArrayValueConverter.
 * 
 * @package     XJConf
 * @subpackage  converters_factories
 */
class ArrayValueConverterFactory implements ValueConverterFactory
{
    /**
     * Decides whether the ArrayValueConverter is responsible for the given Definition.
     *
     * @param   net\xjconf\definitions\Definition  $def
     * @return  boolean     true if is responsible, else false
     */
    public function isResponsible(Definition $def)
    {
        return ($def->getType() == 'array');
    }
    
    /**
     * creates an instance of the ArrayValueConverter
     *
     * @param   net\xjconf\definitions\Definition          $def
     * @return  net\xjconf\converters\ArrayValueConverter
     */
    public function createValueConverter(Definition $def)
    {
        $converter = new ArrayValueConverter();
        return $converter;
    }
}
?>