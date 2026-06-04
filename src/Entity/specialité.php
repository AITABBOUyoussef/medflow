<?php
class specialite {
    private string $name;
    private string $label;

    public function __construct($name, $label)
    {
       $this->name = $name;
       $this->label = $label;
    }
    // getters
    public function getName() : string{
        return $this->name;
    }
    public function getLabel():string{
        return $this->label;
    }
    // setters
    public function setName(string $name){
        return $this->name;
    }
    public function setLabel(string $label){
        return $this->label;
    }
}