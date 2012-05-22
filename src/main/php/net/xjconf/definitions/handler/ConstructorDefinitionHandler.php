<?php
/**
 * Creates a ConstructorDefinition from given xml data.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions_handler
 */
namespace net\xjconf\definitions\handler;
use net\xjconf\DefinitionParser;
use net\xjconf\definitions\ConstructorDefinition;
use net\xjconf\exceptions\InvalidTagDefinitionException;
/**
 * Creates a ConstructorDefinition from given xml data.
 *
 * @package     XJConf
 * @subpackage  definitions_handler
 */
class ConstructorDefinitionHandler implements DefinitionHandler
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
     */
    public function startElement($namespaceURI, $sName, $atts)
    {
        $def = new ConstructorDefinition();
        return $def;
    }
    
    /**
     * End Element handler
     * 
     * @param   string  $namespaceURI  namespace of end tag
     * @param   string  $sName         name of end tag
     * @throws  net\xjconf\exceptions\InvalidTagDefinitionException
     */
    public function endElement($namespaceURI, $sName)
    {
        $defStack       =& $this->defParser->getDefStack();
        $constructorDef = array_pop($defStack);
        $tagDef         = end($defStack);
        try {
            $tagDef->addChildDefinition($constructorDef);
        } catch (\Exception $e) {
            throw new InvalidTagDefinitionException('Could not register the constructor: ' . $e->getMessage());
        }
    }
}
?>