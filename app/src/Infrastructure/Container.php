<?php

namespace App\Infrastructure;


class Container
{
    private $container = [];

    public function __construct(Array $container = [])
    {
        $this->container = array_merge($this->container, $container);
    }

    public function register(String $alias, \Closure $callback)
    {
        array_push($this->container, [
            'alias' => $alias,
            'callback' => $callback
        ]);
    }

    public function get(String $alias)
    {
        foreach($this->container as $registered)
        {
            if($registered['alias'] === $alias)
            {
                return $registered['callback']();
            }
        }
    }
}