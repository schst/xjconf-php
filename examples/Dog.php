<?php
class Dog
{
    protected $properties = array();
    
    public function __set($name, $value)
    {
        $this->properties[$name] = $value;
    }
    
    public function getProperties()
    {
        return $this->properties;
    }
}
?>