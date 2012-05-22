<?php
/**
 * example class
 *
 * @author  Frank Kleine <mikey@xjconf.net>
 */
/**
 * example class
 *
 * @package     XJConf
 * @subpackage  examples
 */
class CDataColor
{
    protected $hex;
    
    public function __construct($hex)
    {
        $this->hex = $hex;
    }
    
    public function getHex()
    {
        return $this->hex;
    }
}
?>