<?php
/**
 * Creates a CDataDefinition from given xml data.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions_handler
 */
namespace net\xjconf\definitions\handler;
use net\xjconf\DefinitionParser;
use net\xjconf\definitions\CDataDefinition;
use net\xjconf\exceptions\InvalidTagDefinitionException;
/**
 * Creates a CDataDefinition from given xml data.
 *
 * @package     XJConf
 * @subpackage  definitions_handler
 */
class CDataDefinitionHandler implements DefinitionHandler
{
    /**
     * the definition parser
     *
     * @var  net\xjconf\DefinitionParser
     */
    private $defParser;
    
    /**
     * init the handler
     *
     * @param  net\xjconf\DefinitionParser  $defParser
     */
    public function init(DefinitionParser $defParser)
    {
        $this->defParser = $defParser;
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
        if (isset($atts['type']) == false) {
            $def = new CDataDefinition();
        } else {
            $def = new CDataDefinition($atts['type']);
        }
        
        // setter
        if (isset($atts['setter']) == true) {
            $def->setSetterMethod($atts['setter']);
        }
        
        return $def;
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
        $defStack =& $this->defParser->getDefStack();
        $cdataDef  = array_pop($defStack);
        $parentDef = end($defStack);
        try {
            $parentDef->addChildDefinition($cdataDef);
        } catch (\Exception $e) {
            throw new InvalidTagDefinitionException('Could not register CData handling: ' . $e->getMessage());
        }
    }
}
?>