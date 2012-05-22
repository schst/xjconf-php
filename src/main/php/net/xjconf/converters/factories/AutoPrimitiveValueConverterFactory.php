<?php
/**
 * Factory for AutoPrimitiveValueConverter objects.
 *
 * @author      Stephan Schmidt <schst@xjconf.net>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  converters_factories
 */
namespace net\xjconf\converters\factories;
use net\xjconf\converters\AutoPrimitiveValueConverter;
use net\xjconf\definitions\Definition;
/**
 * Factory for AutoPrimitiveValueConverter objects.
 *
 * @package     XJConf
 * @subpackage  converters_factories
 */
class AutoPrimitiveValueConverterFactory implements ValueConverterFactory
{
    /**
     * This factory is only responsible, if the type
     * is set to "xjconf:auto-primitive"
     *
     * @param   net\xjconf\definitions\Definition  $def
     * @return  boolean
     */
    public function isResponsible(Definition $def)
    {
        return 'xjconf:auto-primitive' === $def->getType();
    }

    /**
     * Create a value converter
     *
     * @param   net\xjconf\definitions\Definition  $def
     * @return  net\xjconf\converters\ValueConverter
     */
    public function createValueConverter(Definition $def)
    {
        $converter = new AutoPrimitiveValueConverter();
        return $converter;
    }
}
?>