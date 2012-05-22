<?php
/**
 * DefinitionHandler for xml elements that do not define anything.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions_handler
 */
namespace net\xjconf\definitions\handler;
use net\xjconf\DefinitionParser;
/**
 * DefinitionHandler for xml elements that do not define anything.
 *
 * @package     XJConf
 * @subpackage  definitions_handler
 */
class EmptyDefinitionHandler implements DefinitionHandler
{
    /**
     * init the handler
     *
     * @param  net\xjconf\DefinitionParser  $defParser
     */
    public function init(DefinitionParser $defParser)
    {
        // nothing to do
    }
    
    /**
     * Start Element handler
     * 
     * @param   string      $namespaceURI  namespace of start tag
     * @param   string      $sName         name of start tag
     * @param   array       $atts          attributes of tag
     * @return  net\xjconf\definitions\Definition
     * @throws  net\xjconf\exceptions\XJConfException
     */
    public function startElement($namespaceURI, $sName, $atts)
    {
        return null;
    }
    
    /**
     * End Element handler
     * 
     * @param   string  $namespaceURI  namespace of end tag
     * @param   string  $sName         name of end tag
     * @throws  net\xjconf\exceptions\XJConfException
     */
    public function endElement($namespaceURI, $sName)
    {
        // nothing to do
    }
}
?>