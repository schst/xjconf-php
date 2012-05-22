<?php
/**
 * Example class to highlight that it is possible to
 * not pass any data to the constructor.
 *
 * @package     XJConfForPHP
 * @subpackage  examples
 * @author      Stephan Schmidt
 */
class EmptyConstructorClass {
    private $dataFromConstructor;

    public function __construct($data = null) {
        $this->dataFromConstructor = $data;
    }

    public function getDataFromConstructor() {
        return $this->dataFromConstructor;
    }
}
?>