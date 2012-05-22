<?php
/**
 * Factory to create an PrimitiveValueConverter.
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  converters_factories
 */
namespace net\xjconf\converters\factories;
use net\xjconf\converters\PrimitiveValueConverter;
use net\xjconf\definitions\Definition;
/**
 * Factory to create an PrimitiveValueConverter.
 * 
 * @package     XJConf
 * @subpackage  converters_factories
 */
class PrimitiveValueConverterFactory implements ValueConverterFactory {

    private $primitives = array (
                            'int', 'integer', 'double', 'float', 'bool', 'boolean', 'string'
                          );

    public function isResponsible(Definition $def) {
        return in_array($def->getType(), $this->primitives);
    }

    public function createValueConverter(Definition $def) {
        $converter = new PrimitiveValueConverter($def->getType());
        return $converter;
    }
}
?>