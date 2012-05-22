<?php
/**
 * Factory to create the correct ValueConverterFactory.
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  converters_factories
 */
namespace net\xjconf\converters\factories;
use net\xjconf\definitions\Definition;
use net\xjconf\exceptions\ValueConversionException;
/**
 * Factory to create the correct ValueConverterFactory.
 *
 * @package     XJConf
 * @subpackage  converters_factories
 * @static
 */
class ValueConverterFactoryChain
{
    /**
     * contains a list of all available ValueConverterFactorys
     *
     * @var  array<ValueConverterFactory>
     */
    private static $factories = array();

    /**
     * add a ValueConverterFactory to list of known ValueConverterFactorys
     *
     * @param  net\xjconf\converters\factories\ValueConverterFactory  $factory
     */
    public static function push(ValueConverterFactory $factory)
    {
        array_push(self::$factories, $factory);
    }

    /**
     * return the correct ValueConverterFactory depending on the given definition
     *
     * @param   net\xjconf\definitions\Definition                      $def
     * @return  net\xjconf\converters\factories\ValueConverterFactory
     * @throws  net\xjconf\exceptions\ValueConversionException
     */
    public static function getFactory(Definition $def)
    {
        foreach (self::$factories as $factory) {
            if ($factory->isResponsible($def) == true) {
                return $factory;
            }
        }
        
        throw new ValueConversionException('Could not find ValueConverterFactory for definition of tag <' . $def->getName() . '> with type "' . $def->getType() . '". If this type is a class it probably has not been loaded.');
    }

}
// initialize the ValueConverterFactoryChain
ValueConverterFactoryChain::push(new PrimitiveValueConverterFactory());
ValueConverterFactoryChain::push(new AutoPrimitiveValueConverterFactory());
ValueConverterFactoryChain::push(new ArrayValueConverterFactory());
ValueConverterFactoryChain::push(new StaticClassValueConverterFactory());
ValueConverterFactoryChain::push(new ConstructorValueConverterFactory());
ValueConverterFactoryChain::push(new FactoryMethodValueConverterFactory());
?>