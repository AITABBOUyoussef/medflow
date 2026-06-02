<?php
class User {
    private string $name;
    private string $email;
    private string $password;
    
    public function __construct($name , $email , $password)
    {
        $this->name =$name;
        $this->email = $email;
        $this->password = $password;
    }
    // geters
    public function getName() : string{
        return $this->name;
    }
     public function getEmail() : string{
        return $this->email;
    }
     public function getPassword() : string{
        return $this->password;
    }
    // settres
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}