<?php 

namespace App\Infrastructure\Redis;

use App\Infrastructure\Redis\Context;


class SearchRepository
{
    private $context = null;

    private $ttl = 10;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function save(String $terms, Array $results)
    {
        $client = $this->context->connect();

        $key = 'search:' . $terms;

        foreach($results as $name)
        {
            $client->rpush($key, $name);
        }
        $client->expire($key, ($this->ttl * 60));
    }

    public function search(String $terms)
    {
        $client = $this->context->connect();
        $results = $client->lrange('search:' . $terms, 0, -1);

        return $results;
    }
}