<?php
/**
 * Creates a AttributeDefinition from given xml data.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions_handler
 */
namespace net\xjconf\definitions\handler;
use net\xjconf\DefinitionParser;
use net\xjconf\definitions\AttributeDefinition;
use net\xjconf\exceptions\InvalidTagDefinitionException;
/**
 * Creates a AttributeDefinition from given xml data.
 *
 * @package     XJConf
 * @subpackage  definitions_handler
 */
class AttributeDefinitionHandler implements DefinitionHandler
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
            $atts['type'] = $atts['primitive'];
        }

        // ensure that the name has been set
        if (isset($atts['name']) == false) {
            throw new InvalidTagDefinitionException('The <attribute> tag is missing the name attribute.');
        }

        $attDef = new AttributeDefinition($atts['name'], $atts['type']);

        // setter
        if (isset($atts['setter']) == true) {
            $attDef->setSetterMethod($atts['setter']);
        }

        // default value
        if (isset($atts['default']) == true) {
            $attDef->setDefault($atts['default']);
        }

        // required
        if (isset($atts['required']) == true && 'true' == $atts['required']) {
            $attDef->setRequired(true);
        }

        // get the current tag
        $defStack =& $this->defParser->getDefStack();
        $def      = array_pop($defStack);
        try {
            $def->addChildDefinition($attDef);
        } catch (\Exception $e) {
            throw new InvalidTagDefinitionException('Could not register attribute:' .  $e->getMessage());
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
        // nothing to do here
    }
}
?>