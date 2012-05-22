<?php
/**
 * Example class loader.
 * 
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     xjconf
 * @subpackage  examples
 * @version     $Id$
 */
namespace net\xjconf\examples;
use net\xjconf\XJConfClassLoader;
/**
 * Example class loader.
 * 
 * @package     xjconf
 * @subpackage  examples
 */
class ClassLoader implements XJConfClassLoader
{
    /**
     * load the file with the given class
     *
     * @param  string  $fqClassName  the full qualified class name
     */
    public function loadClass($fqClassName)
    {
        require_once __DIR__ . DIRECTORY_SEPARATOR . \str_replace('.', DIRECTORY_SEPARATOR, $fqClassName) . '.php';
    }
    
    /**
     * returns short class name
     *
     * @param  string  $fqClassName  the full qualified class name
     */
    public function getType($fqClassName)
    {
        $className = \explode('.', $fqClassName);
        return $className[\count($className) - 1];
    }
}
?>