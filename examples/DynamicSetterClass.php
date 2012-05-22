<?php
class DynamicSetterClass {
    private $foo;
    private $bar;

    public function setFoo($foo) {
        $this->foo = $foo;
    }
    
    public function getFoo()
    {
        return $this->foo;
    }

    public function setBar($bar) {
        $this->bar = $bar;
    }
    
    public function getBar()
    {
        return $this->bar;
    }
}
?>