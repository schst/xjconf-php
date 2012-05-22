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
class AnotherClass implements MyInterface
{
    /**
     * hold bar
     *
     * @var  MyInterface
     */
	private $bar;
	
	/**
	 * just foo
	 */
	public function foo()
	{
	    // nothing to do here
	}
    
	/**
	 * set bar
	 *
	 * @param  MyInterface  $bar
	 */
	public function setBar(MyInterface $bar)
	{
		$this->bar = $bar;
	}
	
	/**
	 * return bar
	 *
	 * @return  MyInterface
	 */
	public function getBar()
	{
		return $this->bar;
	}
}
?>