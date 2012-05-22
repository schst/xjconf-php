<?php
/**
 * Very basic xInclude mechanism
 *
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConf
 * @subpackage  ext_xinc
 */
namespace net\xjconf\ext\xinc;
use net\xjconf\Tag;
use net\xjconf\XmlParser;
use net\xjconf\exceptions\UnknownTagException;
use net\xjconf\ext\Extension;
/**
 * Very basic xInclude mechanism
 *
 * @package     XJConf
 * @subpackage  ext_xinc
 */
class XInclude implements Extension
{
    /**
     * name of tag
     */
    const TAG_NAME     = 'include';
    /**
     * Namespace of the extension
     *
     * @var  string
     */
    private $namespace = "http://www.w3.org/2001/XInclude";

    /**
     * Get the namspace URI
     *
     * @return  string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Handle an opening tag.
     *
     * Currently this does not do anything.
     *
     * Future versions should check, whether the file exists and skip all
     * child elements.
     *
     * @param  net\xjconf\XmlParser  $parser
     * @param  Tag                   $tag
     */
    public function startElement(XmlParser $reader, Tag $tag)
    {
        // nothing to do here
    }

    /**
     * Handle a closing tag.
     *
     * Does the actual x-include.
     *
     * @param   net\xjconf\XmlParser  $parser
     * @param   net\xjconf\Tag        $tag
     * @return  net\xjconf\Tag
     * @throws  net\xjconf\ext\xinc\XIncludeException
     * @throws  net\xjconf\exceptions\UnknownTagException
     */
    public function endElement(XmlParser $reader, Tag $tag)
    {
        if ($tag->getName() != self::TAG_NAME) {
            throw new UnknownTagException('Unknown tag <' + $tag->getName() . '> in XInclude namespace.');
        }

        $href = $tag->getAttribute('href');
        if (null == $href) {
            return null;
        }

        if (substr($href, 0, 1) != '/') {
            $href = dirname($reader->getCurrentFile()) . '/' . $href;
        }

        try {
            $reader->parse($href);
            return null;
        } catch (\Exception $e) {
            throw new XIncludeException('Could not xInclude ' . $href . ': ' . $e->getMessage());
        }
    }
}
?>