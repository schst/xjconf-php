<?php
/**
 * example class
 * 
 * @author  Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author  Frank Kleine <mikey@xjconf.net>
 */
/**
 * example class
 * 
 * @package     XJConf
 * @subpackage  examples
 */
class ConstructorColor
{
    /**
     * the red part
     *
     * @var  int
     */
    private $red   = null;
    /**
     * the green part
     *
     * @var  int
     */
    private $green = null;
    /**
     * the blue part
     *
     * @var  int
     */
    private $blue  = null;
    
    /**
     * constructor
     * 
     * @param  int  $red
     * @param  int  green
     * @param  int  blue
     */
    public function __construct($red, $green, $blue)
    {
        $this->red   = $red;
        $this->green = $green;
        $this->blue  = $blue;
    }
    
    /**
     * Returns the blue.
     * 
     * @return  int
     */
    public function getBlue()
    {
        return $this->blue;
    }
    
    /**
     * Returns the green.
     * 
     * @return  int
     */
    public function getGreen()
    {
        return $this->green;
    }
    
    /**
     * Returns the red.
     * 
     * @return  int
     */
    public function getRed()
    {
        return $this->red;
    }
    
    /**
     * return a string representation
     *
     * @return  string
     */
    public function __toString()
    {
        return "R: " + $this->getRed() + " / G: " + $this->getGreen() + " / B: " + $this->getBlue();
    }
}
?>