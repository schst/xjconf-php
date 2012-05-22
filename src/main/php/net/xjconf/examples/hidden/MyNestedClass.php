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
namespace net\xjconf\examples\hidden;
/**
 * Class for example purposes.
 * 
 * @package     xjconf
 * @subpackage  examples
 */
class MyNestedClass
{
    /**
     * hold bar
     *
     * @var  object
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
	 * @param  mixed  $bar
	 */
	public function setBar($bar)
	{
		$this->bar = $bar;
	}
	
	/**
	 * return bar
	 *
	 * @return  mixed
	 */
	public function getBar()
	{
		return $this->bar;
	}
}
?>