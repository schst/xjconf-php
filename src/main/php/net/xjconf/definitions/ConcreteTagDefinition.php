<?php
/**
 * Definition of an XML tag.
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions
 */
namespace net\xjconf\definitions;
use net\xjconf\exceptions\InvalidTagDefinitionException;
/**
 * Definition of an XML tag.
 *
 * @package     XJConf
 * @subpackage  definitions
 */
class ConcreteTagDefinition extends TagDefinition
{
    /**
     * Create a new tag definition
     *
     * @param   string  $name  name of the tag
     * @param   string  $type  type of the tag
     * @throws  net\xjconf\exceptions\InvalidTagDefinitionException
     */
    public function __construct($name, $type)
    {
        if (null == $name || strlen($name) == 0) {
            throw new InvalidTagDefinitionException('TagDefinition needs a name.');
        }
        if (null == $type || strlen($type) == 0) {
            throw new InvalidTagDefinitionException('TagDefinition needs a type.');
        }

        $this->name    = $name;
        $this->tagName = $name;
        $this->setType($type);
    }
}
?>