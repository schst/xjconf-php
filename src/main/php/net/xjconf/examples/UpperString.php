<?php
/**
 * Example class returning all values in upper case.
 * 
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     xjconf
 * @subpackage  examples
 * @version     $Id$
 */
namespace net\xjconf\examples;
/**
 * Example class returning all values in upper case.
 * 
 * @package     xjconf
 * @subpackage  examples
 */
class UpperString
{
    /**
     * the data
     *
     * @var  string
     */
    private $data = null;
    
    /**
     * constructor
     *
     * @param  string  $data  the data to make upper case
     */
	public function __construct($data)
	{
        $this->data = \strtoupper($data);
    }
    
    /**
     * returns the upper case string
     *
     * @return  string
     */
    public function getString()
    {
        return $this->data;
    }
}
?>