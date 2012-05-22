<?php
/**
 * Very simple registry class
 * 
 * @author      Stephan Schmidt <stephan.schmidt@schlund.de>
 * @author      Frank Kleine <mikey@xjconf.net>
 * @package     XJConfForPHP
 * @subpackage  examples
 */
/**
 * Very simple registry class
 *
 * @package     XJConfForPHP
 * @subpackage  examples
 */
class Registry {
    protected static $values = array();

    public static function setFoo($foo) {
        self::$values['foo'] = $foo;
    }

    public static function setBar($bar) {
        self::$values['bar'] = $bar;
    }

    public static function export() {
        return self::$values;
    }
}
?>