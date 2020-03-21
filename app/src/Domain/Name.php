<?php 

namespace App\Domain;

class Name
{
    private $name;

    public function __construct(String $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}