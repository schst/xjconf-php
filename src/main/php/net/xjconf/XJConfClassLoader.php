<?php
/**
 * Interface for class loaders that can be used to load classes at runtime.
 *
 * @author   Frank Kleine <mikey@xjconf.net>
 * @package  XJConf
 */
namespace net\xjconf;
/**
 * Interface for class loaders that can be used to load classes at runtime.
 *
 * @package  XJConf
 */
interface XJConfClassLoader
{
    /**
     * load the file with the given class
     *
     * @param  string  $fqClassName  the full qualified class name
     */
    public function loadClass($fqClassName);
    
    /**
     * returns short class name
     *
     * @param  string  $fqClassName  the full qualified class name
     */
    public function getType($fqClassName);
}
?>