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
class ColorPrimitives
{
    /**
     * the red part of the color
     *
     * @var  int
     */
	private $red;
	/**
     * the green part of the color
     *
     * @var  int
     */
    private $green;
    /**
     * the blue part of the color
     *
     * @var  int
     */
    private $blue;
    /**
     * the name of the color
     *
     * @var  int
     */
    private $name       = null;
    /**
     * the title of the color
     *
     * @var  int
     */
    private $colorTitle = null;
    
    /**
     * constructor
     *
     * @var  string  $name  name of the color
     */
    public function __construct($name)
    {
    	$this->name = $name;
    }
    
    /**
     * set the red part
     *
     * @param  int  $val
     */
    public function setRed($val)
    {
        $this->red = $val;
    }
    
    /**
     * set the green part
     *
     * @param  int  $val
     */
    public function setGreen($val) {
        $this->green = $val;
    }
    
    /**
     * set the blue part
     *
     * @param  int  $val
     */
    public function setBlue($val) {
        $this->blue = $val;
    }
    
    /**
     * set the title of the color
     *
     * @param  string  $title
     */
    public function setColorTitle($title)
    {
        $this->colorTitle = $title;
    }
    
    /**
     * get the rgb value as hex
     *
     * @return  string
     */
    public function getRGB()
    {
    	return "#" . dechex($this->red) . dechex($this->green) . dechex($this->blue);
    }
    
    /**
     * return the name of the color
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * return the title of the color
     *
     * @return  string
     */
    public function getColorTitle()
    {
        return $this->colorTitle;
    }
    
    /**
     * returns string representation
     * 
     * @return  string
     */
    public function __toString()
    {
    	return $this->name  . "(" . $this->getRGB() . ")";
    }
}
?>