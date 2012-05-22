<?php
/**
 * Basic example to show how extensions may return values.
 * 
 * @author  Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author  Frank Kleine <mikey@xjconf.net>
 */
use net\xjconf\GenericTag;
use net\xjconf\Tag;
use net\xjconf\XmlParser;
use net\xjconf\ext\Extension;
/**
 * Basic example to show how extensions may return values.
 * 
 * @package     XJConf
 * @subpackage  examples
 */
class MathExtension implements Extension
{
    /**
     * the namespace
     *
     * @var  string
     */
	private $namespace = 'http://www.schst.net/XJConf/Math';
	
	/**
	 * Get the namespace URI used by the extension
	 * 
	 * @return  string
	 */
	public function getNamespace()
	{
		return $this->namespace;
	}
    
	/**
     * Process a start element
     * 
     * @param  XmlParser  $parser
     * @param  Tag        $tag
     * @throws XJConfException
     */
	public function startElement(XmlParser $parser, Tag $tag)
    {
        // nothing to do here
	}
    
	/**
     * Process the end element
     * 
     * @param   XmlParser  $parser
     * @param   Tag        $tag
     * @throws  XJConfException
     */
	public function endElement(XmlParser $parser, Tag $tag)
	{
		// add several values
		if ($tag->getName() == 'add') {
			$result = 0;
			
			$children = $tag->getChildren();
			foreach ($children as $child) {
				$result = $result + $child->getConvertedValue(); 
			}
			
			$resultTag = new GenericTag($tag->getName());
			$resultTag->setValue((double)$result);			
			return $resultTag;
		}
		
		return null;
	}
}
?>