<?php
/**
 * Interface to handle definition tags.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions_handler
 */
namespace net\xjconf\definitions\handler;
use net\xjconf\DefinitionParser;
/**
 * Interface to handle definition tags.
 *
 * A DefinitionHandler can handle xml elements and create definitions out of
 * them using the appropriate Definition class.
 *
 * @package     XJConf
 * @subpackage  definitions_handler
 */
interface DefinitionHandler
{
    /**
     * init the handler
     *
     * @param  net\xjconf\DefinitionParser  $defParser
     */
    public function init(DefinitionParser $defParser);

    /**
     * Start Element handler
     * 
     * @param   string      $namespaceURI  namespace of start tag
     * @param   string      $sName         name of start tag
     * @param   array       $atts          attributes of tag
     * @return  net\xjconf\definitions\Definition
     * @throws  net\xjconf\exceptions\XJConfException
     */
    public function startElement($namespaceURI, $sName, $atts);

    /**
     * End Element handler
     * 
     * @param   string  $namespaceURI  namespace of end tag
     * @param   string  $sName         name of end tag
     * @throws  net\xjconf\exceptions\XJConfException
     */
    public function endElement($namespaceURI, $sName);
}
?>