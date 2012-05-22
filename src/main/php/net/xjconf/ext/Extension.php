<?php
/**
 * Interface for XJConf Extensions
 * 
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  ext
 */
namespace net\xjconf\ext;
use net\xjconf\Tag;
use net\xjconf\XmlParser;
/**
 * Interface for XJConf Extensions
 * 
 * @package     XJConf
 * @subpackage  ext
 */
interface Extension
{
    /**
     * Get the namespace URI used by the extension
     * 
     * @return  string
     */
    public function getNamespace();
    
    /**
     * Process a start element
     * 
     * @param   net\xjconf\XmlParser  $parser
     * @param   net\xjconf\Tag        $tag
     * @throws  net\xjconf\exceptions\XJConfException
     */
    public function startElement(XmlParser $parser, Tag $tag);

    /**
     * Process the end element
     * 
     * @param   net\xjconf\XmlParser  $parser
     * @param   net\xjconf\Tag        $tag
     * @throws  net\xjconf\exceptions\XJConfException
     */
    public function endElement(XmlParser $parser, Tag $tag);
}
?>