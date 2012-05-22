<?php
/**
 * Class for example purposes.
 * 
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     xjconf
 * @subpackage  examples
 * @version     $Id$
 */
namespace net\xjconf\examples;
/**
 * Class for example purposes.
 * 
 * @package     xjconf
 * @subpackage  examples
 */
class MyClass implements MyInterface
{
    /**
     * hold bar
     *
     * @var  net\xjconf\examples\MyInterface
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
	 * @param  net\xjconf\examples\MyInterface  $bar
	 */
	public function setBar(MyInterface $bar)
	{
		$this->bar = $bar;
	}
	
	/**
	 * return bar
	 *
	 * @return  net\xjconf\examples\MyInterface
	 */
	public function getBar()
	{
		return $this->bar;
	}
}
?>