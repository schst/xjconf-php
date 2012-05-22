<?php
/**
 * Interface for factories, that create a value converter for a value.
 *
 * @author      Stephan Schmidt <me@schst.net>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  converters_factories
 */
namespace net\xjconf\converters\factories;
use net\xjconf\definitions\Definition;
/**
 * Interface for factories, that create a value converter for a value.
 *
 * All factories can be put in a chain of responsibility, so
 * that they can decide themselves, whether they are able
 * to create the ValueConverter instance.
 *
 * @package     XJConf
 * @subpackage  converters_factories
 */
interface ValueConverterFactory
{
    /**
     * Check, whether the factory is responsible for
     * creating the ValueConverter for the definition
     *
     * @param   net\xjconf\definitions\Definition  $def
     * @return  boolean
     */
    public function isResponsible(Definition $def);

    /**
     * Create a value converter for the definition
     *
     * @param   net\xjconf\definitions\Definition     $def
     * @return  net\xjconf\converters\ValueConverter
     */
    public function createValueConverter(Definition $def);
}
?>