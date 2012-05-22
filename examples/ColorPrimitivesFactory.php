<?php
/**
 * Example class for the factoryMethod example.
 * 
 * @author  Frank Kleine <mikey@xjconf.net>
 */
/**
 * Example class for the factoryMethod example.
 * 
 * @package     XJConf
 * @subpackage  examples
 */
class ColorPrimitivesFactory
{
    /**
     * creates a new ColorPrimitives object
     *
     * @param   string           $name  name of the color
     * @return  ColorPrimitives
     */
    public static function create($name)
    {
        $colorPrimities = new ColorPrimitives($name);
        return $colorPrimities;
    }
}
?>