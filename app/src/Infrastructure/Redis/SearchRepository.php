<?php 

namespace App\Infrastructure\Redis;

use App\Infrastructure\Redis\Context;
use App\Domain\Name;
use App\Domain\NameCollection;


class SearchRepository
{
    private $context = null;

    private $ttl = 10;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function save(String $terms, NameCollection $results)
    {
        $client = $this->context->connect();

        $key = $this->generateKey($terms);

        foreach($results->all() as $name)
        {
            $client->rpush($key, $name->getName());
        }
        $client->expire($key, ($this->ttl * 60));
    }

    public function search(String $terms)
    {
        $client = $this->context->connect();

        $key = $this->generateKey($terms);
        $results = $client->lrange($key, 0, -1);

        $names = new NameCollection();
        foreach($results as $name)
        {
            $names->add(new Name($name));
        }
        return $names;
    }

    private function generateKey(String $terms)
    {
        return 'search:' . $terms;
    }
}