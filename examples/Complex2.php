<?php
/**
 * example complex class
 *
 * @author  Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author  Frank Kleine <mikey@xjconf.net>
 */
/**
 * example complex class
 *
 * @package     XJConf
 * @subpackage  examples
 */
class Complex2
{
    /**
     * data string
     *
     * @var  string
     */
    private $data = null;
    /**
     * color data
     *
     * @var  Color
     */
    private $color = null;
    /**
     * color string
     *
     * @var  string
     */
    private $colorString = null;
    /**
     * an integer example
     *
     * @var  int
     */
    private $size = 1;

    /**
     * constructor
     *
     * @param  string  $data
     */
    public function __construct($data = null)
    {
    	$this->data = $data;
    }

    /**
     * set the color string
     *
     * @param  string  $colorString
     */
    public function setColorString($colorString)
    {
        $this->colorString = $colorString;
    }

    /**
     * set the color
     *
     * @param  Color  $color
     */
    public function setColor(Color $color)
    {
        $this->color = $color;
    }

    /**
     * set the size
     *
     * @param  int  $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * render all known data
     *
     * @return  string
     */
    public function render()
    {
        if (null == $this->color) {
            return '<font color="' . $this->colorString . '" size="' . $this->size . '">' . $this->data . '</font>';
        } else {
            return '<font title="This text is written in ' . $this->color->getName() . ' (' . $this->color->getColorTitle() . ')" color="' . $this->color->getRGB() . '" size="' . $this->size . '">' . $this->data . '</font>';
        }
    }
}
?>