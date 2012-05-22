<?php
/**
 * Creates a ConcreteTagDefinition from given xml data.
 *
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions_handler
 */
namespace net\xjconf\definitions\handler;
use net\xjconf\DefinitionParser;
use net\xjconf\definitions\ConcreteTagDefinition;
use net\xjconf\definitions\NamespaceDefinition;
use net\xjconf\exceptions\InvalidTagDefinitionException;
/**
 * Creates a ConcreteTagDefinition from given xml data.
 *
 * @package     XJConf
 * @subpackage  definitions_handler
 */
class ConcreteTagDefinitionHandler implements DefinitionHandler
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
     * @throws  net\xjconf\exceptions\InvalidTagDefinitionException
     */
    public function startElement($namespaceURI, $sName, $atts)
    {
        // ensure that the name has been set
        if (isset($atts['name']) == false) {
            throw new InvalidTagDefinitionException('The <tag> tag is missing the name attribute.');
        }

        //
        if (isset($atts['type']) == false) {
            $atts['type'] = $atts['primitive'];
        }

        // The definition extends another definition
        if (isset($atts['extends']) != false) {
            $nsDef = $this->defParser->getNamespaceDefinitions()->getNamespaceDefinition($this->defParser->getCurrentNamespace());
            $extendedDef = $nsDef->getDefinition($atts['extends']);
            if ($extendedDef instanceof ConcreteTagDefinition) {
                $def = clone $extendedDef;
                $def->setName($atts['name']);
                $def->setTagName($atts['name']);
                if (null == $atts['type']) {
                    $def->setType($atts['type']);
                }
            } else {
                $def = new ConcreteTagDefinition($atts['name'], $atts['type']);
                $def->extend($extendedDef);
            }
        } else {
            // Create a definition from scratch
            if (null == $atts['type']) {
                $atts['type'] = 'string';
            }

            $def = new ConcreteTagDefinition($atts['name'], $atts['type']);
        }

        // key attribute
        if (isset($atts['keyAttribute']) == true) {
            $def->setKeyAttribute($atts['keyAttribute']);
        } elseif (isset($atts['key']) == true) {
            $def->setName($atts['key']);
        }

        // setter
        if (isset($atts['setter']) == true) {
            $def->setSetterMethod($atts['setter']);
        }

        // static
        if (isset($atts['static']) == true && strtolower($atts['static']) == 'true') {
            $def->setStatic(true);
        }

        // give definition the correct class loader
        if ($this->defParser->hasClassLoader($this->defParser->getCurrentNamespace()) == true) {
            $def->setClassLoader($this->defParser->getClassLoader($this->defParser->getCurrentNamespace()));
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
        $def      = array_pop($defStack);

        $nsDefs = $this->defParser->getNamespaceDefinitions();

        if ($nsDefs->isNamespaceDefined($this->defParser->getCurrentNamespace()) == false) {
            $nsDefs->addNamespaceDefinition($this->defParser->getCurrentNamespace(), new NamespaceDefinition($this->defParser->getCurrentNamespace()));
        }

        $nsDef = $nsDefs->getNamespaceDefinition($this->defParser->getCurrentNamespace());
        $nsDef->addTagDefinition($def);
    }
}
?>