<?php
/**
 * Class loader for all XJConf classes.
 *
 * @author   Frank Kleine <mikey@xjconf.net>
 * @package  XJConf
 */
namespace net\xjconf;
/**
 * Class loader for all XJConf classes.
 *
 * The class loader takes care that all class files are only loaded once. It
 * allows all classes to include the required files without knowing where they
 * reside or if they have been loaded before.
 *
 * @package  XJConf
 */
class XJConf
{
    /**
     * method to load files from source path
     *
     * @param   string  list of file names to load
     */
    public static function load($className)
    {
        if (self::providesClass($className) === false) {
            return;
        }
        
        if (substr(__FILE__, 0, 7) === 'star://') {
            include str_replace(__CLASS__, $className, __FILE__);
        }

        include __DIR__ . DIRECTORY_SEPARATOR . self::mapClassname($className);
    }

    /**
     * checks whether a file with the given class exists
     *
     * @param   string  $fqClassName
     * @return  bool
     */
    public static function providesClass($className)
    {
        if (substr(__FILE__, 0, 7) === 'star://') {
            return file_exists(str_replace(__CLASS__, $className, __FILE__));
        }
        
        return file_exists(__DIR__ . DIRECTORY_SEPARATOR . self::mapClassname($className));
    }

    /**
     * maps classnames given to loadClass() into required ones for load()
     *
     * @param  string  $classname  name of class given to loadClass()
     * @return string  name of class required for load()
     */
    private static function mapClassname($classname)
    {
        return str_replace('\\', DIRECTORY_SEPARATOR, str_replace('net\xjconf\\', '', $classname)) . '.php';
    }
}
/**
 * register with __autoload()
 */
spl_autoload_register(array('\net\xjconf\XJConf', 'load'));
?>