<?php
/**
 * Factory to create a definition handler of a given type.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions_handler
 */
namespace net\xjconf\definitions\handler;
use net\xjconf\DefinitionParser;
use net\xjconf\XJConf;
/**
 * Factory to create a definition handler of a given type.
 *
 * If the given type maps to an unknown definition handler it will create
 * an EmptyDefinitionHandler instead.
 *
 * @package     XJConf
 * @subpackage  definitions_handler
 * @static
 */
class DefinitionHandlerFactory
{
    /**
     * create a DefinitionHandler
     *
     * @param   string                                            $type       type of DefinitionHandler to create
     * @param   net\xjconf\DefinitionParser                       $defParser
     * @return  net\xjconf\definitions\handler\DefinitionHandler
     */
    public static function create($type, DefinitionParser $defParser)
    {
        if ('tag' === strtolower($type)) {
            $type = 'ConcreteTag';
        }
        
        $className = ucfirst($type) . 'DefinitionHandler';
        if (XJConf::providesClass('net\xjconf\definitions\handler\\' . $className) === false) {
            $className = 'EmptyDefinitionHandler';
        }
        
        $className  = 'net\xjconf\definitions\handler\\' . $className;
        $defHandler = new $className();
        $defHandler->init($defParser);
        return $defHandler;
    }
}
?>