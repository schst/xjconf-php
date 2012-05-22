<?php
/**
 * Class for example purposes.
 * 
 * @author  Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author  Frank Kleine <mikey@xjconf.net>
 */
require_once __DIR__ . '/MyInterface.php';
/**
 * Class for example purposes.
 * 
 * @package     XJConf
 * @subpackage  examples
 */
class MyCollector
{
    /**
     * hold bar
     *
     * @var  array<MyInterface>
     */
    private $bar = array();

    /**
     * set bar
     *
     * @param  MyInterface  $bar
     */
    public function addBar(MyInterface $bar)
    {
        $this->bar[] = $bar;
    }

    public function getBar()
    {
        return $this->bar;
    }
}
?>