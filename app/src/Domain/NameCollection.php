<?php 

namespace App\Domain;

use App\Domain\Name;


class NameCollection
{
    private $names = [];

    public function add(Name $name)
    {
        array_push($this->names, $name);
    }

    public function all()
    {
        return $this->names;
    }

    public function isNotEmpty()
    {
        if(count($this->all()) > 0)
        {
            return true;
        }
        return false;
    }

    public function sort()
    {
        usort($this->names, function(Name $a, Name $b) {
            return $this->alphaSort($a, $b);
        });
    }

    private function alphaSort(Name $a, Name $b)
    {
        return strcasecmp($a->getName(), $b->getName());
    }
}