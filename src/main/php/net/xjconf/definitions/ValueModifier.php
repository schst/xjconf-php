<?php
/**
 * Interface that Definitions have to implement that want to modify a value
 * after it has been conbverted.
 *
 * @author      Stephan Schmidt <schst@php-tools.net>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  definitions
 */
namespace net\xjconf\definitions;
use net\xjconf\Tag;
/**
 * Interface that Definitions have to implement that want to modify a value
 * after it has been conbverted.
 *
 * @package     XJConf
 * @subpackage  definitions
 */
interface ValueModifier
{
    /**
     * Modify the converted value
     *
     * @param   mixed           $value
     * @param   net\xjconf\Tag  $tag
     * @return  mixed           the modified value
     */
    public function modifyValue($value, Tag $tag);
}
?>