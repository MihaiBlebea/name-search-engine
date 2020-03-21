<?php 

namespace App\Application;

use App\Domain\NameCollection;


class SearchResponse
{
    public function format(NameCollection $collection)
    {
        $result = [];
        foreach($collection->all() as $name)
        {
            array_push($result, $name->getName());
        }

        return $result;
    }
}