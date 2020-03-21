<?php 

namespace App\Infrastructure\Mysql;

use App\Infrastructure\Mysql\Context;
use App\Domain\Name;
use App\Domain\NameCollection;


class NameRepository
{
    private $context = null;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function seed(Array $names)
    {
        $conn = $this->context->connect();
        $conn->beginTransaction();

        foreach($names as $name)
        {
            $conn->exec("INSERT INTO names (username) VALUES ('" . $name . "')");
        }
        
        $conn->commit();
        $conn = null;
    }

    public function findByName(String $terms)
    {
        $conn = $this->context->connect();
        
        $stmt = $conn->query("SELECT * FROM names WHERE username LIKE '" . $terms . "%'");
        $result = $stmt->fetchAll();
        
        $names = new NameCollection();

        if(count($result) === 0)
        {
            return $names;
        }

        foreach($result as $row)
        {
            $name = new Name($row['username']);
            $names->add($name);
        }
        return $names;
    }
}